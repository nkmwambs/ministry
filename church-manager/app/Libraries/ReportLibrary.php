<?php 

namespace App\Libraries;

class ReportLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){}

    function unsetViewQueryFields(){}

    function setListQueryFields(){
        $fields = [];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [];
        return $fields;
    }

}