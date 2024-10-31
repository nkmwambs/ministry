<?php 

namespace App\Libraries;

class EventLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['events.id as id','events.name as name','events.code as event_code','meetings.name as meeting_name', '','start_date','end_date','location','events.description as description','events.denomination_id as denomination_id', 'denominations.name as denomination_name','registration_fees'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['events.id as id','events.name as name','meeting_id','events.code as event_code','meetings.name as meeting_name','start_date','end_date','location','events.description as description','events.denomination_id as denomination_id','denominations.name as denomination_name','registration_fees'];
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