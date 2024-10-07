<?php

namespace  App\Libraries;

class  DesignationLibrary implements \App\Interfaces\LibraryInterface {

    public function unsetListQueryFields() {

    }
    public function unsetViewQueryFields(){

    }
    function setListQueryFields(){
        $fields = ['designations.id as id','designations.name as name','denomination_id','denominations.name as denomination_name','is_hierarchy_leader_designation','is_department_leader_designation','is_minister_title_designation'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['designations.id as id','designations.name as name','denomination_id','is_hierarchy_leader_designation','is_department_leader_designation','is_minister_title_designation','denominations.name as denomination_name'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        // $hierarchy_id =0;
        // $department_id =0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        //$page_data['hierarchy_id'] = hash_id($hierarchy_id,'encode');
        //$page_data['department_id'] = hash_id($department_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0; 
        $hierarchy_id = 0;
        $department_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        // $hierarchiesModel = new \App\Models\HierarchiesModel();
        // $hierarchies = $hierarchiesModel->findAll();

        // $departmentsModel = new \App\Models\DepartmentsModel();
        // $departments = $departmentsModel->findAll();

        $page_data['denominations'] = $denominations;
        // $page_data['hierarchies'] = $hierarchies;
        // $page_data['departments'] = $departments;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        // $page_data['hierarchy_id'] = hash_id($hierarchy_id,'encode');
        // $page_data['department_id'] = hash_id($department_id,'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_hierarchy_id = 0;
        $numeric_department_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_hierarchy_id'] = $numeric_hierarchy_id;
        $page_data['numeric_department_id'] = $numeric_department_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();
        
        $hierarchiesModel = new \App\Models\HierarchiesModel();
        $hierarchies = $hierarchiesModel->findAll();

        $departmentsModel = new \App\Models\DepartmentsModel();
        $departments = $departmentsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['hierarchies'] = $hierarchies;
        $page_data['departments'] = $departments;
    }
}
