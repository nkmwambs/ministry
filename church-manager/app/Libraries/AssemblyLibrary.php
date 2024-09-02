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

        // Get lowest entities
        $entitiesModel = new \App\Models\EntitiesModel();
        $entities = $entitiesModel->getLowestEntities(denomination_id: 2);

        $page_data['lowest_entities'] = $entities;

        // Lis denominations and
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $page_data['denominations'] = $denominations;

        return $page_data;
    }
}