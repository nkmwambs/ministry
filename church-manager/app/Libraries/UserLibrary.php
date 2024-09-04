<?php 

namespace App\Libraries;
use App\Interfaces\LibraryInterface;

class UserLibrary implements LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ["denomination_id","first_name","last_name","email","gender","password"];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ["denomination_id","first_name","last_name","email","gender","password"];
        return $fields;
    }
}