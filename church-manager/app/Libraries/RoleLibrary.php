<?php 

namespace App\Libraries;

class RoleLibrary implements \App\Interfaces\LibraryInterface {

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['roles.id','roles.name','permissions','default_role','denomination_id'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['roles.id','roles.name','permissions','default_role','denomination_id','denominations.name as denomination_name'];
        return $fields;
    }
}