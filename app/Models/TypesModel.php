<?php

namespace App\Models;

use CodeIgniter\Model;

class TypesModel extends Model
{
    protected $table            = 'reporttypes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','denomination_id','report_layout','name','type_code'];

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
    protected $afterDelete    = ["updateRecycleBin"];

    public function getAll() {
        $library = new \App\Libraries\TypeLibrary();
        $setQueryFields = $library->setListQueryFields();

        if (!empty($setQueryFields)) {
            return $this->select($library->setListQueryFields())->orderBy('reporttypes.created_at desc')
            ->findAll();
        } else {
            return $this->orderBy('reporttypes.created_at desc')->findAll();
        }
    }

    public function getOne($id) {
        $library = new \App\Libraries\TypeLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())->where('id', $id)
            ->findAll();
        } else {
            return $this->where('id', $id)->findAll();
        }
    }

    public function getEditData($type_id){
        $library = new \App\Libraries\TypeLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('denominations', 'denominations.id = reporttypes.denomination_id')
                ->where('reporttypes.id', $type_id)
                ->first();
        } else {
            return $this->where('id', $type_id)->first();
        }
    }

    public function getViewData($type_id){
        $library = new \App\Libraries\TypeLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('denominations', 'denominations.id = reporttypes.denomination_id')
                ->where('reporttypes.id', $type_id)
                ->first();
        } else {
            return $this->where('id', $type_id)->first();
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
