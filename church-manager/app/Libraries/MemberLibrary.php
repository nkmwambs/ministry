<?php 

namespace App\Libraries;

class MemberLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','first_name','last_name','assembly_id','member_number','designation_id','date_of_birth','email','phone','is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','first_name','last_name','assembly_id','member_number','designation_id','date_of_birth','email','phone','is_active'];
        return $fields;
    }
}