<?php 

namespace App\Libraries;

class HierarchyLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','denomination_id','level'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','denomination_id','level'];
        return $fields;
    }
}