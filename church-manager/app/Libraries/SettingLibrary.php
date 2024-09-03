<?php 

namespace App\Libraries;

class SettingLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','class','key','value','type','context'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','class','key','value','type','context'];
        return $fields;
    }
}