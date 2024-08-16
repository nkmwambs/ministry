<?php 

namespace App\Libraries;

class EntityLibrary implements \App\Interfaces\LibraryInterface {

    private $model = null;

    function __construct(){
        $this->model = new \App\Models\EntitiesModel();
    }
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','minister_number','assembly_id','designation_id','phone','is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','minister_number','assembly_id','designation_id','phone','is_active'];
        return $fields;
    }

    public function getLookUpItems($denomination_id = 0){
        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchies = $hierarchyModel->select('id,name,level')->where('denomination_id', $denomination_id)->where('level <> ', 1)->findAll();

        if($hierarchies){
            $lookUpItems['hierarchy_id'] = $hierarchies;
        }

        

        return $lookUpItems;
    }
}