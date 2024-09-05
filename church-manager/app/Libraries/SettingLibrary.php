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

    function listExtraData(&$page_data){
        
        $parent_id = 0;
       
        if(session()->get('user_denomination_id')){
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }
}