<?php

namespace App\Libraries;

class ReportLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){}

    function unsetViewQueryFields(){}

    function setListQueryFields(){
        $fields = ['reports.id','reports_type_id','report_period','report_date','status','reporttypes.name as reporttype_name'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['reports.id','reports_type_id','report_period','report_date','status','reporttypes.name as reporttype_name'];
        return $fields;
    }
    
    function listExtraData(&$page_data) {
        $parent_id = 0;
        $reports_type_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['report_type_id'] = hash_id($reports_type_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $reports_type_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $typesModel = new \App\Models\TypesModel();
        $types = $typesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['types'] = $types;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['reports_type_id'] = hash_id($reports_type_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_report_type_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $typesModel = new \App\Models\TypesModel();
        $types = $typesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['types'] = $types;
        
        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_report_type_id'] = $numeric_report_type_id;
    }
    function getReportFields ($data) {

        $featureModel = new \App\Models\FeaturesModel();
        $feature_id = $featureModel->where('name', 'report')->first()['id'];

        $fieldModel = new \App\Models\FieldsModel();
        $fields = $fieldModel
        ->select('id,field_name as text')
        ->where('denomination_id', $data['denomination_id'])
        ->where('feature_id', $feature_id)
        ->findAll();

        return ['status' => 'success', 'message' => 'Fields found successful', 'fields' => $fields];
    }
}