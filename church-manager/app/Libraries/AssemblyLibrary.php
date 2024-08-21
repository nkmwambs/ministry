<?php 

namespace App\Libraries;

class AssemblyLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','planted_at','location','entity_id','assembly_leader','is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','planted_at','location','entity_id','assembly_leader','is_active'];
        return $fields;
    }
}