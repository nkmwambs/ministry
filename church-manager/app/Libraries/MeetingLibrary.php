<?php 

namespace App\Libraries;

class MeetingLibrary implements \App\Interfaces\LibraryInterface {

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','denomination_id','name','description'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','denomination_id','name','description'];
        return $fields;
    }
}