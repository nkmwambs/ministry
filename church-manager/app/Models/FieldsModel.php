<?php

namespace App\Models;

use CodeIgniter\Model;

class FieldsModel extends Model
{
    protected $table            = 'customfields';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','denomination_id','name','table_name','type','options','feature_id','field_order','visible'];

    protected bool $allowEmptyInserts = true;
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
        $library = new \App\Libraries\FieldLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('features', 'features.id = customfields.feature_id')
            ->orderBy('customfields.created_at desc')
            ->findAll();
        }else{
            return $this->orderBy('customfields.created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\FieldLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('features', 'features.id = customfields.feature_id')
            ->orderBy('customfields.created_at desc')
            ->where('customfields.id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
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
