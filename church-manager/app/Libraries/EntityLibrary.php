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
        $fields = ['entities.id','entities.entity_number','entities.hierarchy_id','hierarchies.name as hierarchy_name','entities.name','et.parent_id','et.name as parent_name','entities.entity_leader'];
        return $fields;
    }

    public function getLookUpItems(&$page_data){
        $hierarchy_id = hash_id($page_data['parent_id'],'decode');
        
        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchy = $hierarchyModel->where('id', $hierarchy_id)->first();

        $hierarchy_id = $hierarchy['id'];
        $upper_hierarchy_level = $hierarchy['level'] - 1;
        $denomination_id = $hierarchy['denomination_id'];

        $entities = $this->model->where('level', $upper_hierarchy_level)
        ->select('entities.id,entities.name')
        ->join('hierarchies', 'hierarchies.id=entities.hierarchy_id')
        ->where('hierarchies.denomination_id', $denomination_id)->findAll();
        

        if($entities){
            $page_data['parent_entities'] = $entities;
        }

        return $page_data;
    }
}