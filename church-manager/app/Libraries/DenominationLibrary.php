<?php 

namespace App\Libraries;

class DenominationLibrary {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','code','registration_date','email','phone','head_office'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','code','registration_date','email','phone','head_office'];
        return $fields;
    }
}