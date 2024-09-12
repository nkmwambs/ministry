<?php 

namespace App\Libraries;

class MemberLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','first_name','last_name','assembly_id','member_number','designation_id','date_of_birth','email','phone','is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','first_name','last_name','assembly_id','member_number','designation_id','date_of_birth','email','phone','is_active'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['designation_id'] = hash_id($designation_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $designations = $designationsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['designations'] = $designations;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['designation_id'] = hash_id($designation_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_designation_id'] = $numeric_designation_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $designations = $designationsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['designations'] = $designations;
    }
}