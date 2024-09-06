<?php

namespace  App\Libraries;

class  DesignationLibrary implements \App\Interfaces\LibraryInterface {

    public function unsetListQueryFields() {

    }
    public function unsetViewQueryFields(){

    }
    function setListQueryFields(){
        $fields = ['id','name','denomination_id','hierarchy_id','department_id','minister_title_designation'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','denomination_id','hierarchy_id','department_id','minister_title_designation'];
        return $fields;
    }


}
