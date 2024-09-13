<?php 

namespace App\Libraries;

class MinisterLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['ministers.id','ministers.name','minister_number','assembly_id','designation_id','ministers.phone','ministers.is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['ministers.id','ministers.name','minister_number','assembly_id','designation_id','ministers.phone','ministers.is_active'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $assembly_id = 0;
        $designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['assembly_id'] = hash_id($assembly_id,'encode');
        $page_data['designation_id'] = hash_id($designation_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $assembly_id = 0;
        $designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $designations = $designationsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['assemblies'] = $assemblies;
        $page_data['designations'] = $designations;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['assembly_id'] = hash_id($assembly_id, 'encode');
        $page_data['designation_id'] = hash_id($designation_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_assembly_id = 0;
        $numeric_designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $designations = $designationsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['assemblies'] = $assemblies;
        $page_data['designations'] = $designations;
        
        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_assembly_id'] = $numeric_assembly_id;
        $page_data['numeric_designation_id'] = $numeric_designation_id;
    }
}