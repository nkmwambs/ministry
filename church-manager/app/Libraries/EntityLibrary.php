<?php 

namespace App\Libraries;

class EntityLibrary implements \App\Interfaces\LibraryInterface {

    private $model = null;

    function __construct(){
        $this->model = new \App\Models\EntitiesModel();
    }
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','entity_number','hierarchy_id','name','parent_id','entity_leader'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','entity_number','hierarchy_id','name','parent_id','entity_leader'];
        return $fields;
    }

    public function getLookUpItems($hierarchy_id = 0){
        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchy = $hierarchyModel->where('id', $hierarchy_id)->first();

        $hierarchy_id = $hierarchy['id'];
        $upper_hierarchy_level = $hierarchy['level'] - 1;
        $denomination_id = $hierarchy['denomination_id'];

        $entities = $this->model->where('level', $upper_hierarchy_level)
        ->select('entities.id,entities.name')
        ->join('hierarchies', 'hierarchies.id=entities.hierarchy_id')
        ->where('hierarchies.denomination_id', $denomination_id)->findAll();
        
        $lookUpItems['hierarchy_id'] = [];

        if($entities){
            $lookUpItems['parent_id'] = $entities;
        }

        return $lookUpItems;
    }
}