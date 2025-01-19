<?php 

namespace App\Libraries;

class AssemblyLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['assemblies.id','assemblies.name','assembly_code','planted_at','assemblies.location','assemblies.entity_id','entities.name as entity_name','assemblies.assembly_leader','assemblies.is_active'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['assemblies.id','assemblies.name','assembly_code','planted_at','assemblies.location','assemblies.entity_id','entities.name as entity_name','assemblies.assembly_leader','assemblies.is_active'];
        return $fields;
    }

    public function addExtraData(&$page_data){
        $entities = [];

        if($page_data['parent_id']){
            $denomination_id = hash_id($page_data['parent_id'],'decode'); // session()->get('user_denomination_id');
            // Get lowest entities
            $entitiesModel = new \App\Models\EntitiesModel();
            $entities = $entitiesModel->getLowestEntities($denomination_id);
        }
        
        $page_data['lowest_entities'] = $entities;


        if (session()->get('user_denomination_id')) {
            $page_data['parent_id'] = session()->get('user_denomination_id');
        }

        // List denominations and
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $page_data['denominations'] = $denominations;

        return $page_data;
    }

    public function editExtraData(&$page_data){
        $entities = [];
        
        // Get lowest entities
        $entitiesModel = new \App\Models\EntitiesModel();

        $denomination_id = $entitiesModel->select('denominations.id')
        ->join('hierarchies','hierarchies.id=entities.hierarchy_id')
        ->join('denominations','denominations.id=hierarchies.denomination_id')
        ->join('assemblies','assemblies.entity_id=entities.id')
        ->find($page_data['result']['entity_id'])['id'];

        $ministersModel = new \App\Models\MinistersModel();
        $ministersModel->select('ministers.id,members.first_name,members.last_name')
        ->join('members','members.id=ministers.member_id')
        ->where('ministers.is_active', 'yes');
        $ministers = $ministersModel->findAll();

        $page_data['parent_id'] = $denomination_id;
        $page_data['ministers'] = $ministers;

        $entities = $entitiesModel->getLowestEntities($page_data['parent_id']);
        $page_data['lowest_entities'] = $entities;

        // List of denominations
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();
        $page_data['denominations'] = $denominations;

        return $page_data;
    }

    function getAssemblyDenominationIdByAssemblyId($assembly_id){
        $assemblyModel = new \App\Models\AssembliesModel();
        $assembly = $assemblyModel
        ->join('entities', 'entities.id = assemblies.entity_id')
        ->join('hierarchies', 'hierarchies.id=entities.hierarchy_id')
        ->join('denominations', 'denominations.id=hierarchies.denomination_id')
        ->find($assembly_id);
        return $assembly['denomination_id'];
    }
}