<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignationsModel extends Model
{
    protected $table            = 'designations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','name','denomination_id','is_hierarchy_leader_designation','is_department_leader_designation','is_minister_title_designation'];

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
    
    public function getAll() {
        $library = new \App\Libraries\DesignationLibrary();
        $listQueryFields = $library->setListqueryFields();

        if (!empty($listQueryFields)) {
            return $this->select($library->setListqueryFields())
            ->join('denominations', 'denominations.id = designations.denomination_id')
            -> orderBy('designations.created_at desc')
            ->findAll();
        }else{
            return $this->orderBy('designations.created_at desc')->findall();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\DesignationLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty ($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) -> where('id', $id)-> first();
        }else {
            return $this->where('id', $id) ->first();
        }
    }

    public function getEditData($designation_id){
        $library = new \App\Libraries\DesignationLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('denominations', 'denominations.id = designations.denomination_id')
                ->where('designations.id', $designation_id)
                ->first();
        } else {
            return $this->where('id', $designation_id)->first();
        }
    }

    public function getViewData($designation_id){
        $library = new \App\Libraries\MeetingLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('denominations', 'denominations.id = designations.denomination_id')
                ->where('designations.id', $designation_id)
                ->first();
        } else {
            return $this->where('id', $designation_id)->first();
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


