<?php 

namespace App\Libraries;

class SystemLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [];
        return $fields;
    }

    function getParentId($primary_key_value, $table_name) {
        
        $collectionsModels = new \App\Models\CollectionsModel();
        if (property_exists($collectionsModels, 'parent_schema')) {

        }
    }
}