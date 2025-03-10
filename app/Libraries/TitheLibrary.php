<?php 

namespace App\Libraries;

class TitheLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [
            'tithes.id','tithing_date','member_id','amount','members.assembly_id as assembly_id','members.first_name as member_first_name','members.last_name as member_last_name'
        ];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [
            'tithes.id','tithing_date','member_id','amount','members.assembly_id as assembly_id','members.first_name as member_first_name','members.last_name as member_last_name'
        ];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $member_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['member_id'] = hash_id($member_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $member_id = 0;

        // log_message('error', json_encode($page_data['parent_id']));

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }else{
            $parent_id = hash_id($page_data['parent_id'], 'decode');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $membersModel = new \App\Models\MembersModel();
        $members = $membersModel->getAll();

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->loggedUserPermittedAssemblies();

        $page_data['denominations'] = $denominations;
        $page_data['members'] = $members;
        $page_data['assemblies'] = $assemblies;

        // $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['member_id'] = hash_id($member_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_member_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_member_id'] = $numeric_member_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $membersModel = new \App\Models\MembersModel();
        $members = $membersModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['members'] = $members;
    }
}