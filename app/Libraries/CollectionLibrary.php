<?php 

namespace App\Libraries;

class CollectionLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [
            'collections.id','return_date','period_start_date','sunday_date',
            'period_end_date','assembly_id','assemblies.name as assembly_name','revenue_id','collections.amount',
            'status','collection_reference','collections.description','collection_method',
            'revenues.name as revenue_name','sunday_count'
        ];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [
            'collections.id','assembly_id','assemblies.name as assembly_name','revenue_id','revenues.name as revenue_name','return_date','collections.amount'
        ];
        return $fields;
    }

    function listExtraData(&$page_data) {
        $parent_id = 0;
        $revenue_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['revenue_id'] = hash_id($revenue_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $revenue_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->loggedUserPermittedAssemblies();

        $revenuesModel = new \App\Models\RevenuesModel();
        $revenues = $revenuesModel->findAll();

        $membersModel = new \App\Models\MembersModel();
        $members = $membersModel->findAll();

        $page_data['assemblies'] = $assemblies;
        $page_data['revenues'] = $revenues;
        $page_data['members'] = $members;

        $page_data['currentReportingMonth'] = "2025-02-01";

        $page_data['parent_id'] = $parent_id == 0 ? $page_data['parent_id'] :hash_id($parent_id,'encode');
        $page_data['revenue_id'] = hash_id($revenue_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_revenue_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_revenue_id'] = $numeric_revenue_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $revenuesModel = new \App\Models\RevenuesModel();
        $revenues = $revenuesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['revenues'] = $revenues;
    }
}