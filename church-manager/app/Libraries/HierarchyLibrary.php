<?php 

namespace App\Libraries;

class HierarchyLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','hierarchy_code','denomination_id','level','description'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['hierarchies.id','hierarchies.name','hierarchies.denomination_id','denominations.name as denomination_name','hierarchies.level','hierarchies.description'];
        return $fields;
    }

    function editExtraData(&$page_data){
        $denomination_id = $page_data['result']['id']; 
        $denominationsModel = new \App\Models\DenominationsModel();
        $page_data['number_of_denomination_assemblies'] = $denominationsModel->getDenominationAssembliesCount($denomination_id);
        return $page_data;
    }
}