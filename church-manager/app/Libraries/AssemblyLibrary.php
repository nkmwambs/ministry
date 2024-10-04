<?php 

namespace App\Libraries;

class AssemblyLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['assemblies.id','assemblies.name','assembly_code','assemblies.planted_at','assemblies.location','assemblies.entity_id','entities.name entity_name','assemblies.assembly_leader','assemblies.is_active', 'hierarchies.denomination_id as denomination_id'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['assemblies.id','assemblies.name','assembly_code','planted_at','location','entities.id as entity_id','entities.name as entity_name','ministers.name as assembly_leader','assemblies.is_active','hierarchies.denomination_id as denomination_id'];
        return $fields;
    }

    public function addExtraData(&$page_data){
        $entities = [];
        // log_message('error', json_encode($page_data['parent_id']));

        if($page_data['parent_id']){
            $denomination_id = hash_id($page_data['parent_id'],'decode'); // session()->get('user_denomination_id');
            // Get lowest entities
            $entitiesModel = new \App\Models\EntitiesModel();
            $entities = $entitiesModel->getLowestEntities($denomination_id);
        }
        
        $page_data['lowest_entities'] = $entities;

        // Lis denominations and
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $page_data['denominations'] = $denominations;

        return $page_data;
    }

    public function editExtraData(&$page_data){
        $entities = [];

        $denomination_id = $page_data['result']['denomination_id'];
        
        // Get lowest entities
        $entitiesModel = new \App\Models\EntitiesModel();
        $entities = $entitiesModel->getLowestEntities($denomination_id);
        $page_data['lowest_entities'] = $entities;

        // List of denominations
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();
        $page_data['denominations'] = $denominations;

        return $page_data;
    }
}