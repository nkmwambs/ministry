<?php

namespace App\Models;

use CodeIgniter\Model;

class AssembliesModel extends Model implements \App\Interfaces\ModelInterface
{
    protected $table            = 'assemblies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','name', 'assembly_code','planted_at','location','entity_id','assembly_leader','is_active'];

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
        $library = new \App\Libraries\AssemblyLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())->orderBy('assemblies.created_at desc')
            ->join('entities','entities.id=assemblies.entity_id')
            ->join('ministers','ministers.id=assemblies.assembly_leader', 'left')
            ->join('hierarchies','hierarchies.id=entities.hierarchy_id')
            ->findAll();
        }else{
            return $this->orderBy('assemblies.created_at desc')->findAll();
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

    public function getViewData($numeric_id){
        $library = new \App\Libraries\AssemblyLibrary();
        $viewQueryFields = $library->setViewQueryFields();
        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())->where('assemblies.id', $numeric_id)
            ->join('entities','entities.id = assemblies.entity_id')
            ->join('hierarchies','hierarchies.id = entities.hierarchy_id')
            ->join('ministers','ministers.id = assemblies.assembly_leader','left')
            ->first();
        }else{
            return $this->where('id', $this->id)->first();
        }
    }

    public function getEditData($numeric_id){
        $library = new \App\Libraries\AssemblyLibrary();
        $viewQueryFields = $library->setViewQueryFields();
        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())->where('assemblies.id', $numeric_id)
            ->join('entities','entities.id = assemblies.entity_id')
            ->join('hierarchies','hierarchies.id = entities.hierarchy_id')
            ->join('ministers','ministers.id = assemblies.assembly_leader', 'left')
            ->first();
        }else{
            return $this->where('id', $this->id)->first();
        }
    }

    public function getListData(){

        $library = new \App\Libraries\AssemblyLibrary();
        $listQueryFields = $library->setListQueryFields();

        $assemblies = [];

        if(session()->get('user_denomination_id')){
            $assemblies = $this->where(['hierarchies.denomination_id' => session()->get('user_denomination_id')])
            ->select(!empty($listQueryFields) ? $listQueryFields : '*')
            ->join('entities', 'entities.id = assemblies.entity_id')
            ->join('hierarchies', 'hierarchies.id = entities.hierarchy_id')
            ->findAll();
        }else{
            // $assemblies = $this->getAll();
            $assemblies = $this->select(!empty($listQueryFields) ? $listQueryFields : '*')
            ->join('entities', 'entities.id = assemblies.entity_id')
            ->join('hierarchies', 'hierarchies.id = entities.hierarchy_id')
            ->findAll();
        }

        return $assemblies;
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

    function getAssembliesByDenominationId($hashed_denomination_id){
        return $this->where(['hierarchies.denomination_id' => hash_id($hashed_denomination_id, 'decode')])
        ->select('assemblies.id, assemblies.name')
        ->join('entities','entities.id = assemblies.entity_id')
        ->join('hierarchies','hierarchies.id = entities.hierarchy_id')
        ->findAll();
    }

    
}
