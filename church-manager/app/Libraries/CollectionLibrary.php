<?php 

namespace App\Libraries;

class CollectionLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [
            'collections.id','return_date','period_start_date',
            'period_end_date','assembly_id','revenue_id','collections.amount',
            'status','collection_reference','description','collection_method'
        ];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [
            'collections.id','return_date','period_start_date',
            'period_end_date','assembly_id','revenue_id','collections.amount',
            'status', 'collection_reference','description','collection_method'
        ];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $assembly_id = 0;
        $revenue_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['assembly_id'] = hash_id($assembly_id,'encode');
        $page_data['revenue_id'] = hash_id($revenue_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $assembly_id = 0;
        $revenue_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $assembliesModel = new \App\Models\DenominationsModel();
        $denominations = $assembliesModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $assemblies = $designationsModel->findAll();

        $revenuesModel = new \App\Models\RevenuesModel();
        $revenues = $revenuesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['assemblies'] = $assemblies;
        $page_data['revenues'] = $revenues;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['designation_id'] = hash_id($assembly_id, 'encode');
        $page_data['revenue_id'] = hash_id($revenue_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_assemblies_id = 0;
        $numeric_revenues_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_assemblies_id'] = $numeric_assemblies_id;
        $page_data['numeric_revenues_id'] = $numeric_revenues_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $assemblies = $designationsModel->findAll();

        $revenuesModel = new \App\Models\RevenuesModel();
        $revenues = $revenuesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['assemblies'] = $assemblies;
        $page_data['revenues'] = $revenues;
    }
}