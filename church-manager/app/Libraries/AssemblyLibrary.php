<?php 

namespace App\Libraries;

class AssemblyLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','planted_at','location','entity_id','assembly_leader','is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','planted_at','location','entity_id','assembly_leader','is_active'];
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
}