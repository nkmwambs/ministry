<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';// \App\Entities\UserEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id","denomination_id",
        "first_name","last_name",
        "username","biography",
        "date_of_birth","email",
        "gender","phone","roles",
        "access_count",
        "is_active",
        "permitted_entities",
        "permitted_assemblies",
        "created_at",
        "updated_at",
        "password"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['updateRecycleBin'];

    function getAll(){
        $library = new \App\Libraries\UserLibrary();
        $listQueryFields = $library->setListQueryFields();

        if (!empty($listQueryFields)) {
            return $this->select($library->setListQueryFields())->orderBy('created_at desc')->findAll();
        } else {
            $this->orderBy('created_at desc')->findAll();
        }
    }

    function getOne($id){
        $library = new \App\Libraries\UserLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())->where('id', $id)->first();
        } else {
            $this->where('id', $id)->first();
        }
    }

    public function getEditData($user_id){
        $library = new \App\Libraries\UserLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=users.denomination_id','left')
            ->where('users.id', $user_id)->first();
            // log_message('error', json_encode($var_return));
            // return $var_return;
        }else{
            return $this->where('id', $user_id)->first();
        }
    }

    public function getViewData($user_id){
        $library = new \App\Libraries\UserLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=users.denomination_id')
            ->where('users.id', $user_id)->first();
        }else{
            return $this->where('id', $user_id)->first();
        }
    }

    function updateRecycleBin($data){

        $trashModel = new \App\Models\TrashesModel();
        $trashData = [
            'item_id' => $data['id'][0],
            'item_deleted_at' => date('Y-m-d H:i:s')
        ];
        $trashModel->insert((object)$trashData);
        return true;
    }
}
