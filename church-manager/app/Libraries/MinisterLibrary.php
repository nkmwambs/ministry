<?php 

namespace App\Libraries;

class MinisterLibrary {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','minister_number','assembly_id','designation_id','phone','is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','minister_number','assembly_id','designation_id','phone','is_active'];
        return $fields;
    }
}