<?php 

namespace App\Libraries;
use App\Interfaces\LibraryInterface;

class ParticipantLibrary implements LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','member_id','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','member_id','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }
}