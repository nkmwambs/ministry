<?php 

namespace App\Libraries;

class EventLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','gatheringtype_id','start_date','end_date','location','description','denomination_id','registration_fees'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','gatheringtype_id','start_date','end_date','location','description','denomination_id','registration_fees'];
        return $fields;
    }
}