<?php 

namespace App\Libraries;

class MinisterLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [
            'ministers.id','minister_number','member_id','ministers.is_active',
            'members.first_name as member_first_name','members.last_name as member_last_name','members.gender',
            'members.assembly_id','members.member_number as member_number','members.designation_id','members.is_active',
            'members.date_of_birth','members.email','members.phone as member_phone','members.saved_date',
            'members.inactivation_reason','members.membership_date','license_number','designations.name as designation_name',
            'assemblies.name as assembly_name'
        ];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [
            'license_number','ministers.id','minister_number','members.member_number as member_number','member_id',
            'members.first_name as member_first_name','members.last_name as member_last_name','members.gender',
            'ministers.is_active','members.assembly_id','members.designation_id',
            'members.date_of_birth','members.email','members.phone as member_phone','members.saved_date',
            'members.inactivation_reason','members.membership_date'
        ];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $assembly_id = 0;
        // $designation_id = 0;
        $member_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['assembly_id'] = hash_id($assembly_id,'encode');
        // $page_data['designation_id'] = hash_id($designation_id,'encode');
        $page_data['member_id'] = hash_id($member_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $assembly_id = 0;
        $member_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->loggedUserPermittedAssemblies();

        $page_data['denominations'] = $denominations;
        $page_data['assemblies'] = $assemblies;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['assembly_id'] = hash_id($assembly_id, 'encode');

        $members = [];
        if ($page_data['assembly_id']) {
            $assembly_id = hash_id($page_data['assembly_id'], 'decode');

            $membersModel = new \App\Models\MembersModel();
            $members = $membersModel->select('members.*, designations.is_minister_title_designation')
            ->join('designations', 'designations.id = members.designation_id')
            ->where('designations.is_minister_title_designation', 'yes')
            ->where('members.assembly_id', $assembly_id)
            ->orderBy('members.first_name', 'ASC')->findAll();
        }

        $page_data['members'] = $members;
        $page_data['member_id'] = hash_id($member_id,'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_assembly_id = 0;
        $numeric_member_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();
        
        $assembliesModel = new \App\Models\AssembliesModel();
        $assemblies = $assembliesModel->findAll();

        $membersModel = new \App\Models\MembersModel();
        $members = $membersModel->select('members.*, designations.is_minister_title_designation')
        ->join('designations', 'designations.id = members.designation_id')
        ->where('designations.is_minister_title_designation', 'yes')
        ->orderBy('members.first_name', 'ASC')->findAll();

        $minister = $membersModel->select('members.*,members.id as member_id,designations.is_minister_title_designation')
        ->join('designations', 'designations.id = members.designation_id')
        ->join('ministers', 'ministers.member_id = members.id')
        ->where('ministers.id', $page_data['result']['id'])
        ->orderBy('members.first_name', 'ASC')->first();

        $designationsModel = new \App\Models\DesignationsModel();
        $ministerialDesignations = $designationsModel->where('is_minister_title_designation', 'yes')
        ->findAll();
        

        $page_data['designations'] = $ministerialDesignations;
        $page_data['denominations'] = $denominations;
        $page_data['assemblies'] = $assemblies;
        $page_data['members'] = $members;
        $page_data['minister'] = $minister;
        
        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_assembly_id'] = $numeric_assembly_id;
        $page_data['numeric_member_id'] = $numeric_member_id;
    }
}