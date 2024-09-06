<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','name','permissions','default_role','denomination_id'];

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
    protected $afterDelete    = [];

    function getAll(){
        $library = new \App\Libraries\RoleLibrary();
        $setQueryFields = $library->setListQueryFields();

        if (!empty($setQueryFields)) {
            return $this->select($library->setListQueryFields())
            ->orderBy('roles.created_at desc')->findAll();
        } else {
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    function getOne($id){
        $library = new \App\Libraries\RoleLibrary;
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
            ->where('id', $id)->first();
        } else {
            return $this->where('id', $id)->first();
        }
    }
    
    public function getEditData($department_id){
        $library = new \App\Libraries\RoleLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('denominations', 'denominations.id = roles.denomination_id')
                ->where('roles.id', $department_id)
                ->first();
        } else {
            return $this->where('roles.id')->first();
        }
    }

    public function getViewData($role_id){
        $library = new \App\Libraries\RoleLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('denominations', 'denominations.id = roles.denomination_id')
                ->where('roles.id', $role_id)
                ->first();
        } else {
            return $this->where('id', $role_id)->first();
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
