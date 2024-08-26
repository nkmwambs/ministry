<?php 

namespace App\Libraries;

class VisitorLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','first_name','last_name','phone','email','gender','date_of_birth','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','first_name','last_name','phone','email','gender','date_of_birth','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }
}