<?php

namespace App\Models;

use CodeIgniter\Model;

class HierarchiesModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'hierarchies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','hierarchy_code','description','denomination_id','level'];

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
        $library = new \App\Libraries\HierarchyLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('denominations', 'denominations.id = hierarchies.denomination_id')
            ->orderBy('hierarchies.created_at desc')->findAll();
        }else{
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\HierarchyLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations', 'denominations.id = hierarchies.denomination_id')
            ->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    function getLowestHierarchyLevel($denomination_id){
        $lowestHierarchyLevel = $this->where('denomination_id', $denomination_id)->orderBy('level', 'desc')->first();
        return $lowestHierarchyLevel['level'];
    }

    function getViewData($hierarchy_id){
        $library = new \App\Libraries\HierarchyLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->where('hierarchies.id', $hierarchy_id)->first();
        }else{
            return $this->where('id', $hierarchy_id)->first();
        }
    }

    function getEditData($hierarchy_id){
        $library = new \App\Libraries\HierarchyLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->where('hierarchies.id', $hierarchy_id)->first();
        }else{
            return $this->where('id', $hierarchy_id)->first();
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

    // function createHeadOfficeEntity(array $data){
    //     if($data['data']['level'] == 1){
    //         $headOfficeEntityData = [
    //             'hierarchy_id' => $data['id'],
    //             'name' => 'Head Office',
    //             'entity_number' => 'H001',
    //             'parent_id' => null,
    //         ];
    
    //         $entityModel = new EntitiesModel();
    //         $entityModel->insert($headOfficeEntityData);
    //     }
    //     return true;
    // }
}
