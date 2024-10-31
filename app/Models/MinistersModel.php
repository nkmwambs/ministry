<?php

namespace App\Models;

use CodeIgniter\Model;

class MinistersModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'ministers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','minister_number','member_id','is_active'];

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

    public function getAll(){
        $library = new \App\Libraries\MinisterLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('members', 'members.id = ministers.member_id')
            // ->join('assemblies', 'assemblies.id = members.assembly_id')
            // ->join('designations', 'designations.id = members.designation_id')
            ->findAll();
        }else{
            return $this->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\MinisterLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('members', 'members.id = ministers.member_id')
            ->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($minister_id){
        $library = new \App\Libraries\MinisterLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('members', 'members.id = ministers.member_id')
                ->where('ministers.id', $minister_id)
                ->first();
        } else {
            return $this->where('id', $minister_id)->first();
        }
    }

    public function getViewData($minister_id){
        $library = new \App\Libraries\MinisterLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('members', 'members.id = ministers.member_id')
                ->where('ministers.id', $minister_id)
                ->first();
        } else {
            return $this->where('id', $minister_id)->first();
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
