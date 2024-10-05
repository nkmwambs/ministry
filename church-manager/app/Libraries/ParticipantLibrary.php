<?php 

namespace App\Libraries;
use App\Interfaces\LibraryInterface;

class ParticipantLibrary implements LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['participants.id','member_id','event_id','events.name as event_name','payment_id','payment_code','registration_amount','status','members.first_name as member_name'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['participants.id','member_id','event_id','payment_id','payment_code','registration_amount','status','members.name as member_name'];
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
        $member_id = 0;
        $event_id = hash_id($page_data['parent_id'], 'decode');

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();
        
        $members = $this->getUnregisteredMembersForEvent($event_id);

        $eventsModel = new \App\Models\EventsModel();
        $event = $eventsModel->find($event_id);

        $page_data['denominations'] = $denominations;
        $page_data['members'] = $members;
        $page_data['registration_fees'] = $event['registration_fees'];
        $page_data['member_id'] = hash_id($member_id, 'encode');
    }

    function getUnregisteredMembersForEvent($eventId){
     
        // Subquery to get member IDs that are in the participants table for the given event_id    
        $participantsModel = new \App\Models\ParticipantsModel();
        $eventParticipants = $participantsModel
        ->select('member_id')
        ->where('event_id', $eventId)
        ->findAll();

        // Main query to get members whose IDs are not in the subquery
        $membersModel = new \App\Models\MembersModel();
        $members = $membersModel->whereNotIn('id', array_column($eventParticipants,'member_id'))
        ->findAll();
        return $members;
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

    function insertParticipants(array $data){
        $registration_amount = count($data['member_id']) > 1 ? $data['due_registration_amount']/count($data['member_id']) : $data['due_registration_amount'];
        foreach($data['member_id'] as $memberId){
            $participantModel = new \App\Models\ParticipantsModel();

            $insert_data['member_id'] = $memberId;
            $insert_data['event_id'] = $data['event_id'];
            $insert_data['registration_amount'] = $registration_amount;
            $insert_data['status'] = 'registered';

            $participantModel->insert((object)$insert_data);
        }
    }
}