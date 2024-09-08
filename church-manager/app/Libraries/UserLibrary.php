<?php 

namespace App\Libraries;
use App\Interfaces\LibraryInterface;

class UserLibrary implements LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ["users.id","users.denomination_id","first_name","last_name","date_of_birth","email","gender","phone","roles","access_count","is_active","permitted_entities","permitted_assemblies"];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ["users.id","users.denomination_id","first_name","last_name","date_of_birth","email","gender","phone","roles","access_count","is_active","permitted_entities","permitted_assemblies"];
        return $fields;
    }

    function listExtraData(&$page_data){
        
        $parent_id = 0;

        if(session()->get('user_denomination_id')){
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }

    // function addExtraData(&$page_data){
    //     $parent_id = 0;
    //     $entity_id = 0;
    //     $hierarchy_id = 0;

    //     if(session()->get('user_denomination_id')){
    //         $parent_id = session()->get('user_denomination_id');
    //     }

    //     $denominationsModel = new \App\Models\DenominationsModel();
    //     $denominations = $denominationsModel->findAll();

    //     $entitiesModel = new \App\Models\EntitiesModel();
    //     $entities = $entitiesModel->findAll();

    //     $hierarchiesModel = new \App\Models\HierarchiesModel();
    //     $hierarchies = $hierarchiesModel->findAll();

    //     $page_data['denominations'] = $denominations;
    //     $page_data['entities'] = $entities;
    //     $page_data['hierarchies'] = $hierarchies;

    //     $page_data['parent_id'] = hash_id($parent_id,'encode');
    //     $page_data['entity_id'] = hash_id($entity_id, 'encode');
    //     $page_data['hierarchy_id'] = hash_id($hierarchy_id, 'encode');
    // }

    public function addExtraData(&$page_data)
    {
        $parent_id = 0;
        $entity_id = 0;
        $hierarchy_id = 0;

        // Get the parent_id from the session, if available
        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        // Fetch data from the relevant models
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $entitiesModel = new \App\Models\EntitiesModel();
        $entities = $entitiesModel->select('entities.id, entities.name, entities.hierarchy_id, hierarchies.name as hierarchy_name')
                                  ->join('hierarchies', 'hierarchies.id = entities.hierarchy_id')
                                  ->orderBy('hierarchies.name, entities.name')
                                  ->findAll();

        // Group entities by hierarchy
        $grouped_entities = [];
        foreach ($entities as $entity) {
            $grouped_entities[$entity['hierarchy_name']][] = $entity;
        }

        $hierarchiesModel = new \App\Models\HierarchiesModel();
        $hierarchies = $hierarchiesModel->findAll();

        // Assign the data to the page_data array
        $page_data['denominations'] = $denominations;
        $page_data['entities'] = $grouped_entities;  // Updated to use grouped entities
        $page_data['hierarchies'] = $hierarchies;

        // Encode the IDs for security
        $page_data['parent_id'] = hash_id($parent_id, 'encode');
        $page_data['entity_id'] = hash_id($entity_id, 'encode');
        $page_data['hierarchy_id'] = hash_id($hierarchy_id, 'encode');
    }


    function editExtraData(&$page_data){
        $numeric_denomination_id = 0;
        $numeric_hierarchy_id = 0;
        $numeric_entity_id = 0;

        if(session()->get('user_denomination_id')){
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_hierarchy_id'] = $numeric_hierarchy_id;
        $page_data['numeric_entity_id'] = $numeric_entity_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $entitiesModel = new \App\Models\EntitiesModel();
        $entities = $entitiesModel->select('entities.id, entities.name, entities.hierarchy_id, hierarchies.name as hierarchy_name')
        ->join('hierarchies', 'hierarchies.id = entities.hierarchy_id')
        ->orderBy('hierarchies.name, entities.name')
        ->findAll();

        // Group entities by hierarchy
        $grouped_entities = [];
        foreach ($entities as $entity) {
            $grouped_entities[$entity['hierarchy_name']][] = $entity;
        }

        $hierarchiesModel = new \App\Models\HierarchiesModel();
        $hierarchies = $hierarchiesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['entities'] = $grouped_entities;
        $page_data['hierarchies'] = $hierarchies;
    }
}