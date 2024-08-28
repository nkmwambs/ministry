<?php 

namespace App\Libraries;

class CollectionLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','return_date','period_start_date','period_end_date','assembly_id','collection_type_id','amount','status','collection_reference','description','collection_method'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','return_date','period_start_date','period_end_date','assembly_id','collection_type_id','amount','status','collection_reference','description','collection_method'];
        return $fields;
    }
}