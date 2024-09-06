<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignationsModel extends Model
{
    protected $table            = 'designations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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




        public function get_designations() {
            $this->model->select('designation.id, designation.name as designation_name, denomination.name as denomination_name, hierarchy.name as hierarchy_name, department.name as department_name');
            $this->model->from('designation');
            $this->model->join('denomination', 'designation.denomination_id = denomination.id', 'left');
            $this->model->join('hierarchy', 'designation.hierarchy_id = hierarchy.id', 'left');
            $this->model->join('department', 'designation.department_id = department.id', 'left');
            $query = $this->model->getAll();
    
            return $query->result_array();
        }
    
    
    public function getAll() {

        $library = new \App\Libraries\DesignationLibrary();
        $listQueryFields = $library->setListqueryFields();

        if (!empty($listQueryFields)) {
            return $this->select($library->setListqueryFields())
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

}


