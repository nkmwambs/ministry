<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentsModel extends Model implements \App\Interfaces\ModelInterface
{
    protected $table            = 'departments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','denomination_id','name','description'];

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

    public function getAll(){
        $library = new \App\Libraries\DepartmentLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->orderBy('departments.created_at desc')
            ->findAll();
        }else{
            return $this->orderBy('departments.created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\AssemblyLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($department_id){
        $library = new \App\Libraries\DepartmentLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=departments.denomination_id')
            ->where('departments.id', $department_id)->first();
        }else{
            return $this->where('id', $department_id)->first();
        }
    }

    public function getViewData($department_id){
        $library = new \App\Libraries\DepartmentLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=departments.denomination_id')
            ->where('departments.id', $department_id)->first();
        }else{
            return $this->where('id', $department_id)->first();
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
