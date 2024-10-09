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
        $fields = ['entities.id','entities.entity_number','entities.hierarchy_id','entities.name','entities.parent_id','entities.name as parent_name','entities.entity_leader'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['entities.id','entities.entity_number','entities.hierarchy_id','entities.name','entities.parent_id','entities.name as parent_name','entities.entity_leader'];
        return $fields;
    }

    public function getLookUpItems(&$page_data){
        $hierarchy_id = hash_id($page_data['parent_id'],'decode');
        
        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchy = $hierarchyModel->where('hierarchies.id', $hierarchy_id)->first();

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


    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $hierarchy_id =0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['hierarchy_id'] = hash_id($hierarchy_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0; 
        $hierarchy_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $hierarchiesModel = new \App\Models\HierarchiesModel();
        $hierarchies = $hierarchiesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['hierarchies'] = $hierarchies;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['hierarchy_id'] = hash_id($hierarchy_id,'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_hierarchy_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_hierarchy_id'] = $numeric_hierarchy_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();
        
        $hierarchiesModel = new \App\Models\HierarchiesModel();
        $hierarchies = $hierarchiesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['hierarchies'] = $hierarchies;
    }
}