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
        // $parent_id = 0;
        $reports_type_id = 0;
        $assembly_id = 0;

        // if (session()->get('user_denomination_id')) {
        //     $parent_id = session()->get('user_denomination_id');
        // }


        // $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['report_type_id'] = hash_id($reports_type_id,'encode');
        $page_data['assembly_id'] = hash_id($assembly_id, 'encode');
    }

    function addExtraData(&$page_data) {
        // $parent_id = $page_data['parent_id'];
        $denomination_id = 0; // service('uri')->getSegments()[2];
        $assembly_id = 0;

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominationsQuery = $denominationsModel;
        if (session()->get('user_denomination_id')) {
            $denomination_id = session()->get('user_denomination_id');
            $denominationsQuery->where('reporttypes.denomination_id', $denomination_id);
            $denominationsQuery->join('reporttypes', 'reporttypes.denomination_id = reports.reports_type_id');
        }
        $denominations = $denominationsQuery->findAll();

        $typesModel = new \App\Models\TypesModel();
        $types = $typesModel->findAll();

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['types'] = $types;
        $page_data['assemblies'] = $assemblies;

        // $page_data['parent_id'] = hash_id($parent_id,'decode');
        $page_data['denomination_id'] = $denomination_id;
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
        ->where('visible', 'yes')
        ->findAll();

        return ['status' => 'success', 'message' => 'Fields found successful', 'fields' => $fields];
    }

    function viewExtraData(&$page_data){
        $numericReportId = $page_data['result']['id'];
        // Get report Type 
        $reportModel = new \App\Models\ReportsModel();
        $report = $reportModel
        ->select(
            'reports.id, 
            assembly_id, 
            reports_type_id, 
            reporttypes.name as report_type_name,
            reporttypes.type_code, 
            reports.report_date, 
            reports.report_period,
            reporttypes.requires_mobile_money,
            reporttypes.remittance_amount_builder,
            assemblies.name as assembly_name')
        ->join('reporttypes','reporttypes.id=reports.reports_type_id')
        ->join('assemblies','assemblies.id=reports.assembly_id')
        ->find($numericReportId);
        
        $reportTypeId = $report['reports_type_id'];

        // Get report layout from report type
        $reportTypeModel = new \App\Models\TypesModel();
        $reportType = $reportTypeModel->find($reportTypeId);
        $reportLayout = json_decode($reportType['report_layout'], true);

        // Build the report object with fields info
        $fieldLibrary = new \App\Libraries\FieldLibrary();
        $fieldModel = new \App\Models\FieldsModel();
        for($i = 0; $i < count($reportLayout); $i++){
            for($j = 0; $j < count($reportLayout[$i]['section_parts']); $j++){
                // Taking the string of custom fields Ids to an individual array element
                $reportLayout[$i]['section_parts'][$j]['part_fields'] = $this->sortPartFields($reportLayout[$i]['section_parts'][$j]['part_fields'][0]);
                // $reportLayout[$i]['section_parts'][$j]['part_fields'] is an array of custom fields Ids
                $reportLayout[$i]['section_parts'][$j]['part_fields'] = array_map(function($fieldTypeId) use($fieldLibrary, $fieldModel, $report){
                    return $fieldLibrary->getFieldUIElementProperties($fieldTypeId, $fieldModel, $report);
                }, $reportLayout[$i]['section_parts'][$j]['part_fields']);
            }   
        }

        $page_data['report_fields'] = $reportLayout;
        $page_data['type_code'] = $report['type_code'];
        $page_data['report_type_name'] = $report['report_type_name'];
        $page_data['report_period'] = $report['report_period'];
        $page_data['requires_mobile_money'] = $report['requires_mobile_money'];
        $page_data['remittance_amount_builder'] = $report['remittance_amount_builder'];
        $page_data['assembly_name'] = $report['assembly_name'];

        return $page_data;
    }

    function sortPartFields($partFieldsStr){
        $partFieldsIds = explode(',', $partFieldsStr);

        // Sorting the fields based on their field_order column
        $fieldsModel = new \App\Models\FieldsModel();
        $fields = $fieldsModel->select('id,field_order')
        ->whereIn('id', $partFieldsIds)
        ->orderBy('field_order', 'asc')
        ->findAll();

        $orderedPartFieldsIds = array_column($fields, 'id');

        return $orderedPartFieldsIds;
    }


    static function autoGenerateMonthlyReport(){
        $monthEndDate = date('Y-m-t');
        // Last month end date
        // $lastMonthDate = date('Y-m-t', strtotime($monthEndDate.'-1 month'));

        // List all assemblies 
        $reportModel = new \App\Models\ReportsModel();
        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->findAll();

        // Get all report types
        $typesModel = new \App\Models\TypesModel();
        $types = $typesModel->where('scheduler','monthly')->findAll();

        foreach($assemblies as $assembly){
            foreach($types as $type){
                $reportsCount = $reportModel
                ->where('assembly_id', $assembly['id'])
                ->where('reports_type_id', $type['id'])
                ->where('report_period', $monthEndDate)
                ->countAllResults();

                if($reportsCount == 0){
                    // Create the report if it doesn't exist
                    $data = (object)[
                        'assembly_id' => $assembly['id'],
                       'reports_type_id' => $type['id'],
                       'report_date' => NULL,
                       'report_period' => $monthEndDate,
                       'status' => 'draft'
                    ];
                    $reportModel->insert($data);
                }
            }
            
        }
       
    }

    function convertCustomNamedFieldsToIds(&$postArray){
        $fieldsModel = new \App\Models\FieldsModel();

        $arrayKeys = array_keys($postArray);
        $fieldCodeWithIds = $fieldsModel->select('id,field_code,type,options')->whereIn('field_code', $arrayKeys)->findAll();

        $fieldCodesWithIdValues = array_combine(array_column($fieldCodeWithIds,'field_code'),array_column($fieldCodeWithIds,'id'));


       $result = [];
        foreach($postArray as $key => $value){
            $result[$fieldCodesWithIdValues[$key]] = $this->getFieldValues($key,$value, $fieldCodeWithIds); //$value;
        }

        $postArray = $result;

        return $postArray;
    }

    function getFieldValues($field_code, $value, $fieldCodeWithIds){
        $fieldCodesWithTypeValues = array_combine(array_column($fieldCodeWithIds,'field_code'),array_column($fieldCodeWithIds,'type'));
        // $fieldCodesWithOptionsValues = array_combine(array_column($fieldCodeWithIds,'field_code'),array_column($fieldCodeWithIds,'options'));
    
        $returnValue = $value;

        if($fieldCodesWithTypeValues[$field_code] == 'boolean'){
            // Assumes all boolean choices are yes/no
            if($value == 1){
                $returnValue = 'yes';
            }else{
                $returnValue = 'no';
            }
        }

        if($fieldCodesWithTypeValues[$field_code] == 'numeric' && $value == ""){
            $returnValue = 0;
        }

        if($fieldCodesWithTypeValues[$field_code] == 'text' && $value == ""){
            $returnValue = NULL;
        }

        return $returnValue;
    }
   
}