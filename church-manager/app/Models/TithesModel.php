<?php

namespace App\Models;

use CodeIgniter\Model;

class TithesModel extends Model
{
    protected $table            = 'tithes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','member_id','assembly_id','amount'];

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

    public function getAll(){
        $library = new \App\Libraries\TitheLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('assemblies', 'assemblies.id = tithes.assembly_id')
            ->join('members','members.id = tithes.member_id')
            ->orderBy('tithes.created_at desc')->findAll();
        }else{
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\TitheLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('assemblies', 'assemblies.id = tithes.assembly_id')
            ->join('members','members.id = tithes.member_id')
            ->where('tithes.id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($tithe_id){
        $library = new \App\Libraries\TitheLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('assemblies', 'assemblies.id = tithes.assembly_id')
                ->join('members','members.id = tithes.member_id')
                ->where('tithes.id', $tithe_id)
                ->first();
        } else {
            return $this->join('members','members.id = tithes.member_id')
            ->where('tithes.id', $tithe_id)->first();
        }
    }

    public function getViewData($tithe_id){
        $library = new \App\Libraries\TitheLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            $result = $this->select($library->setViewQueryFields()) 
                ->join('assemblies', 'assemblies.id = tithes.assembly_id')
                ->join('members','members.id = tithes.member_id')
                ->where('tithes.id', $tithe_id)
                ->first();
                
            unset($result['id']);
            unset($result['assembly_id']);
            unset($result['member_id']);

            return $result;
        } else {
            return $this->where('id', $tithe_id)->first();
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
