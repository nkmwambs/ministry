<?php 

namespace App\Libraries;

class MemberLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [
            'members.id','first_name','last_name','gender',
            'assembly_id','member_number','designation_id','designations.name as designation_name',
            'date_of_birth','members.email','members.phone','members.is_active','members.saved_date','members.inactivation_reason','members.membership_date'
        ];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [
            'members.id','first_name','last_name','gender',
            'assembly_id','assemblies.name as assembly_name','member_number','designation_id','designations.name as designation_name',
            'date_of_birth','members.email','members.phone','members.is_active','members.saved_date','members.inactivation_reason','members.membership_date'
        ];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['designation_id'] = hash_id($designation_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $designations = $designationsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['designations'] = $designations;

        // $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['designation_id'] = hash_id($designation_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_designation_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_designation_id'] = $numeric_designation_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $designations = $designationsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['designations'] = $designations;
    }

    function viewExtraData(&$page_data){
        $denominations = [];
        $designations = [];

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $designationsModel = new \App\Models\DesignationsModel();
        $designations = $designationsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['designations'] = $designations;
    }

    function makeUser($data){
        $member_id = $data['member_id'];

        $membersModel = new \App\Models\MembersModel();
        $member = $membersModel->find($member_id);

        $userModel = new \App\Models\UsersModel();

        $password = generateRandomString(8);

        $denomination_id = 3;

        $data = [
            'denomination_id' => $denomination_id,
            'first_name' => $member['first_name'],
            'last_name' => $member['last_name'],
            'phone' => $member['phone'],
            'active' => 1,
            'gender' => $member['gender'],
            'date_of_birth' => $member['date_of_birth'],
            'roles' => json_encode([1]),
            'email' => $member['email'],
            'permitted_entities' => NULL,
            'permitted_assemblies' =>  json_encode([$member['assembly_id']]),
            'is_system_admin' => NULL,
            'password' => $password,
            'associated_member_id' => $member['id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $user = new \CodeIgniter\Shield\Entities\User($data);
        $userModel->insert($user, true);
        $insertId = $userModel->getInsertID();

        $user->id = $insertId;
        $userModel->addToDefaultGroup($user);

        $status = "failed";
        $message = "Failed to convert";

        if($insertId){
            $status = "success";
            $message = "Successfully converted";
        }

        return compact('status', 'message');
    }
}