<?php

namespace App\Libraries;

class ReportLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){}

    function unsetViewQueryFields(){}

    function setListQueryFields(){
        $fields = ['reports.id','reports_type_id','assembly_id','reporttypes.denomination_id','report_period','report_date','status','reporttypes.name as reporttype_name','assemblies.name as assembly_name','denominations.name as denomination_name'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['reports.id','reports_type_id','assembly_id','reporttypes.denomination_id','report_period','report_date','status','reporttypes.name as reporttype_name','assemblies.name as assembly_name','denominations.name as denomination_name'];
        return $fields;
    }
    
    function listExtraData(&$page_data) {
        $parent_id = 0;
        $reports_type_id = 0;
        $assembly_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['report_type_id'] = hash_id($reports_type_id,'encode');
        $page_data['assembly_id'] = hash_id($assembly_id, 'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $reports_type_id = 0;
        $assembly_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $typesModel = new \App\Models\TypesModel();
        $types = $typesModel->findAll();

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['types'] = $types;
        $page_data['assemblies'] = $assemblies;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['reports_type_id'] = hash_id($reports_type_id, 'encode');
        $page_data['assembly_id'] = hash_id($assembly_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_report_type_id = 0;
        $numeric_assembly_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $typesModel = new \App\Models\TypesModel();
        $types = $typesModel->findAll();

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['types'] = $types;
        
        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_report_type_id'] = $numeric_report_type_id;
        $page_data['numeric_assembly_id'] = $numeric_assembly_id;
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

    function viewExtraData(&$page_data){

        // log_message('error', json_encode($page_data));

        $numericReportId = $page_data['result']['id'];
        // Get report Type 
        $reportModel = new \App\Models\ReportsModel();
        $report = $reportModel->find($numericReportId);
        $reportTypeId = $report['reports_type_id'];

        // Get report layout from report type
        $reportTypeModel = new \App\Models\TypesModel();
        $reportType = $reportTypeModel->find($reportTypeId);
        $reportLayout = json_decode($reportType['report_layout'], true);
        
        // Build the report object with fields info
        $typeLibrary = new \App\Libraries\FieldLibrary();
        $fieldModel = new \App\Models\FieldsModel();
        for($i = 0; $i < count($reportLayout); $i++){
            for($j = 0; $j < count($reportLayout[$i]['section_parts']); $j++){
                // Taking the string of custom fields Ids to an individual array elemement
                $reportLayout[$i]['section_parts'][$j]['part_fields'] = explode(',',$reportLayout[$i]['section_parts'][$j]['part_fields'][0]);
                // $reportLayout[$i]['section_parts'][$j]['part_fields'] is an array of custom fields Ids
                $reportLayout[$i]['section_parts'][$j]['part_fields'] = array_map(function($fieldTypeId) use($typeLibrary, $fieldModel){
                    return $typeLibrary->getFieldUIElementProperties($fieldTypeId, $fieldModel);
                }, $reportLayout[$i]['section_parts'][$j]['part_fields']);
            }   
        }
        
        $page_data['report_fields'] = $reportLayout;
        return $page_data;
    }
}