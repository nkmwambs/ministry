<?php 

namespace App\Libraries;

class DenominationLibrary implements \App\Interfaces\LibraryInterface {
    private $model = null;

    function __construct(){
        $this->model = new \App\Models\DenominationsModel();
    }

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','name','code','registration_date','email','phone','head_office'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','name','code','registration_date','email','phone','head_office'];
        return $fields;
    }

    function editExtraData(&$page_data){
        $id = hash_id($page_data['id'], 'decode');
        
        $countDenominationEntities = $this->model->getDenominationEntitiesCount($id);
        
        // $this->model->where('denominations.id', $id)
        // ->join('hierarchies','hierarchies.denomination_id=denominations.id')
        // ->join('entities','entities.hierarchy_id=hierarchies.id')
        // ->countAllResults();

        $page_data['denomination_entities_count'] = $countDenominationEntities;

        return $page_data;
    }
}