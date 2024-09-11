<?php 

namespace App\Libraries;

class EventLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','meeting_id','start_date','end_date','location','description','denomination_id','registration_fees'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','meeting_id','start_date','end_date','location','description','denomination_id','registration_fees'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $meeting_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['meeting_id'] = hash_id($meeting_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $meeting_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $meetingsModel = new \App\Models\MeetingsModel();
        $meetings = $meetingsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['meetings'] = $meetings;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['meeting_id'] = hash_id($meeting_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_meeting_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_meeting_id'] = $numeric_meeting_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $meetingsModel = new \App\Models\MeetingsModel();
        $meetings = $meetingsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['meetings'] = $meetings;
    } 
}