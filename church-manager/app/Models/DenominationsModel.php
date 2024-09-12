<?php

namespace App\Models;

use CodeIgniter\Model;

class DenominationsModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'denominations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["name","code","registration_date","head_office","email","phone"];

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
    protected $afterInsert    = ["createHighestHierarchyAndEntity"];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAll(){
        $library = new \App\Libraries\DenominationLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())->orderBy('created_at desc')->findAll();
        }else{
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\DenominationLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    function createHighestHierarchyAndEntity(array $data){
        $topHierarchy = [];
        $topHierarchy['name'] = "Head Office";
        $topHierarchy['denomination_id'] = $data['id'];
        $topHierarchy['level'] = 1;
        $topHierarchy['description'] = "Head Office";

        $hierarchyModel = new HierarchiesModel();
        $hierarchyModel->insert((object)$topHierarchy);
        $hierarchyId = $hierarchyModel->getInsertID();

        $entityData = [
            'hierarchy_id' => $hierarchyId,
            'name' => 'Head Office',
            'entity_number' => 'H001',
            'parent_id' => null,
            'entity_leader' => null,
        ];

        $entityModel = new EntitiesModel();
        $entityModel->insert((object)$entityData);
        return $hierarchyId;
    }

    public function getDenominationEntitiesCount($id): int {
       
        $countDenominationEntities = $this->where('denominations.id', $id)
        ->join('hierarchies','hierarchies.denomination_id=denominations.id')
        ->join('entities','entities.hierarchy_id=hierarchies.id')
        ->countAllResults();

        return $countDenominationEntities;
    }

    public function getDenominationAssembliesCount($id){

        $countDenominationAssemblies = $this->where('denominations.id', $id)
        ->join('hierarchies','hierarchies.denomination_id=denominations.id')
        ->join('entities','entities.hierarchy_id=hierarchies.id')
        ->join('assemblies','assemblies.entity_id=entities.id')
        ->countAllResults();

        return $countDenominationAssemblies;
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
