<?php 

namespace App\Libraries;

class MemberLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ["first_name","last_name","member_number","designation_id","date_of_birth","email","phone","is_active","assembly_id"];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ["first_name","last_name","member_number","designation_id","date_of_birth","email","phone","is_active","assembly_id"];
        return $fields;
    }
}