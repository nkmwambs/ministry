<?php 

namespace App\Libraries;

class MinisterLibrary implements \App\Interfaces\LibraryInterface {
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