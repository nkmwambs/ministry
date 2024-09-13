<?php 

namespace App\Libraries;
use App\Interfaces\LibraryInterface;

class ParticipantLibrary implements LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['id','member_id','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['id','member_id','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        $member_id = 0;
        $payment_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['member_id'] = hash_id($member_id,'encode');
        $page_data['payment_id'] = hash_id($payment_id,'encode');
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;
        $member_id = 0;
        $payment_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $membersModel = new \App\Models\MembersModel();
        $members = $membersModel->findAll();

        $paymentsModel = new \App\Models\PaymentsModel();
        $payments = $paymentsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['members'] = $members;
        $page_data['payments'] = $payments;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
        $page_data['member_id'] = hash_id($member_id, 'encode');
        $page_data['payment_id'] = hash_id($payment_id, 'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_member_id = 0;
        $numeric_payment_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_member_id'] = $numeric_member_id;
        $page_data['numeric_payment_id'] = $numeric_payment_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $membersModel = new \App\Models\MembersModel();
        $members = $membersModel->findAll();

        $paymentsModel = new \App\Models\PaymentsModel();
        $payments = $paymentsModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['members'] = $members;
        $page_data['payments'] = $payments;
    }
}