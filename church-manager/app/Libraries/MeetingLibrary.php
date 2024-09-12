<?php 

namespace App\Libraries;

class MeetingLibrary implements \App\Interfaces\LibraryInterface {

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['meetings.id','denomination_id','meetings.name','meetings.description'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['meetings.id','denomination_id','meetings.name','meetings.description','denominations.name as denomination_name'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $page_data['denominations'] = $denominations;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $page_data['denominations'] = $denominations;
    }
}