<?php 

namespace App\Libraries;
use App\Interfaces\LibraryInterface;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserLibrary implements LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ["users.id","users.denomination_id","first_name","last_name","username","biography","date_of_birth","gender","users.phone","roles","access_count","active","permitted_entities","permitted_assemblies","users.updated_at"];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ["users.id","users.denomination_id","first_name","last_name","username","biography","date_of_birth","gender","users.phone","roles","access_count","active","permitted_entities","permitted_assemblies","users.updated_at"];
        return $fields;
    }

    function listExtraData(&$page_data){
        
        $parent_id = 0;

        if(session()->get('user_denomination_id')){
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }

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
                                  ->orderBy('hierarchies.level, hierarchies.name, entities.name')
                                  ->findAll();

        // Group entities by hierarchy
        $grouped_entities = [];
        foreach ($entities as $entity) {
            $grouped_entities[$entity['hierarchy_name']][] = $entity;
        }

        $hierarchiesModel = new \App\Models\HierarchiesModel();
        $hierarchies = [];

        if(session()->get('user_denomination_id')){
            $hierarchies = $hierarchiesModel->where('denomination_id', session()->get('user_denomination_id'))->findAll();
        }else{
            $hierarchies = $hierarchiesModel->findAll();
        }

        // Assign the data to the page_data array
        $page_data['denominations'] = $denominations;
        $page_data['entities'] = $grouped_entities;  // Updated to use grouped entities
        $page_data['hierarchies'] = $hierarchies;

        // Encode the IDs for security
        $page_data['parent_id'] = hash_id($parent_id, 'encode');
        $page_data['entity_id'] = hash_id($entity_id, 'encode');
        $page_data['hierarchy_id'] = hash_id($hierarchy_id, 'encode');

        // Fetch and assign roles for the current user
        $rolesModel = new \App\Models\RolesModel();
        $roles = [];

        if(session()->get('user_denomination_id')){
            $roles = $rolesModel->where('denomination_id', session()->get('user_denomination_id'))->findAll();
        }else{
            $roles = $rolesModel->findAll();
        }
        $page_data['roles'] = $roles;
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

    function viewExtraData(&$page_data){
        $denominations = [];
        $hierarchies = [];
        $entities = [];

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $hierarchiesModel = new \App\Models\HierarchiesModel();
        $hierarchies = $hierarchiesModel->findAll();

        $entitiesModel = new \App\Models\EntitiesModel();
        $entities = $entitiesModel->select('entities.id, entities.name, entities.hierarchy_id, hierarchies.name as hierarchy_name')
        ->join('hierarchies', 'hierarchies.id = entities.hierarchy_id')
        ->orderBy('hierarchies.name, entities.name')
        ->findAll();

        $grouped_entities = [];
        foreach ($entities as $entity) {
            $grouped_entities[$entity['hierarchy_name']][] = $entity;
        }

        $page_data['denominations'] = $denominations;
        $page_data['entities'] = $grouped_entities;
        $page_data['hierarchies'] = $hierarchies;
    }

    public function exportUserDataToPdf($user_data) {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->setFont('helvetica', '', 12);
        $pdf->setCellPaddings(0, 10, 0, 10);

        $html = '<h1>User Data<h1>';
        $html .= '<table border="1">';
        foreach ($user_data as $user_field_name => $user_value) {
            $html .= '<tr>';
            $html .= '<td>' . ucfirst($user_field_name) . '</td>';
            $html .= '<td>' . $user_value . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf->Output('user_data.pdf', 'D'); // Download the PDF file directly to the user's browser
    }

    public function exportUserDataXlsx() {
        // $spreadsheet = new Spreadsheet();
    }
}