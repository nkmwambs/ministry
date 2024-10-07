<?php

namespace App\Libraries;
use App\Interfaces\LibraryInterface;

class ParticipantLibrary implements LibraryInterface
{


    function unsetListQueryFields()
    {

    }

    function unsetViewQueryFields()
    {

    }

    function setListQueryFields()
    {
        $fields = ['participants.id', 'member_id', 'event_id', 'events.name as event_name', 'payment_id','payments.payment_code as payment_code', 'registration_amount', 'status', 'members.first_name as member_name'];
        return $fields;
    }

    function setViewQueryFields()
    {
        $fields = ['participants.id', 'member_id', 'event_id', 'payment_id', 'registration_amount', 'status', 'members.name as member_name'];
        return $fields;
    }

    function listExtraData(&$page_data)
    {

        $parent_id = 0;
        $member_id = 0;
        $payment_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id, 'encode');
        $page_data['member_id'] = hash_id($member_id, 'encode');
        $page_data['payment_id'] = hash_id($payment_id, 'encode');
    }

    function addExtraData(&$page_data)
    {
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

    function getUnregisteredMembersForEvent($eventId)
    {

        // Subquery to get member IDs that are in the participants table for the given event_id    
        $participantsModel = new \App\Models\ParticipantsModel();
        $eventParticipants = $participantsModel
            ->select('member_id')
            ->where('event_id', $eventId)
            ->findAll();

        $members = [];

        if (count($eventParticipants) > 0) {
            // Main query to get members whose IDs are not in the subquery
            $membersModel = new \App\Models\MembersModel();
            $members = $membersModel->whereNotIn('id', array_column($eventParticipants, 'member_id'))
                ->findAll();
        } else {
            $membersModel = new \App\Models\MembersModel();
            $members = $membersModel->findAll();
        }


        return $members;
    }

    function editExtraData(&$page_data)
    {
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

    // function insertParticipants(array $data, array $mpesa_response){

    //     // Insert the payment request
    //     $paymentModel = new \App\Models\PaymentsModel();
    //     $insert_payment_data['MerchantRequestID'] = $mpesa_response['MerchantRequestID'];
    //     $insert_payment_data['phone'] = $data['paying_phone_number'];
    //     $insert_payment_data['amount'] = $data['due_registration_amount'];
    //     $insert_payment_data['status'] = 'pending'; // Awaiting confitmation of payment from Safaricom stk
    //     $paymentModel->insert((object)$insert_payment_data);

    //     // Get the insert id
    //     $payment_id = $paymentModel->getInsertID();

    //     $registration_amount = count($data['member_id']) > 1 ? $data['due_registration_amount']/count($data['member_id']) : $data['due_registration_amount'];
    //     foreach($data['member_id'] as $memberId){
    //         $participantModel = new \App\Models\ParticipantsModel();

    //         $insert_data['member_id'] = $memberId;
    //         $insert_data['event_id'] = $data['event_id'];
    //         $insert_data['payment_id'] = $payment_id;
    //         $insert_data['registration_amount'] = $registration_amount;
    //         $insert_data['status'] = 'pending'; // AWaiting confitmation of payment from Safaricom stk

    //         $participantModel->insert((object)$insert_data);
    //     }
    // }

    function insertParticipants(array $data, array $mpesa_response)
    {
        // Load necessary models
        $paymentModel = new \App\Models\PaymentsModel();
        $participantModel = new \App\Models\ParticipantsModel();

        // Start the transaction
        $db = \Config\Database::connect();
        $db->transStart(); // Start the transaction

        try {
            // Insert the payment request
            $insert_payment_data = [
                'MerchantRequestID' => $mpesa_response['MerchantRequestID'],
                'phone' => $data['paying_phone_number'],
                'amount' => $data['due_registration_amount'],
                'status' => 'pending', // Awaiting confirmation of payment from Safaricom stk
            ];

            $paymentModel->insert((object)$insert_payment_data); // Insert into payments table

            // Get the insert ID
            $payment_id = $paymentModel->getInsertID();

            // Calculate registration amount per member
            $registration_amount = count($data['member_id']) > 1
                ? $data['due_registration_amount'] / count($data['member_id'])
                : $data['due_registration_amount'];

            // Loop through each member and insert the participant record
            foreach ($data['member_id'] as $memberId) {
                $insert_data = [
                    'member_id' => $memberId,
                    'event_id' => $data['event_id'],
                    'payment_id' => $payment_id,
                    'registration_amount' => $registration_amount,
                    'status' => 'pending', // Awaiting confirmation of payment
                ];

                $participantModel->insert((object)$insert_data); // Insert into participants table
            }

            // Commit the transaction if all queries succeed
            $db->transComplete(); // End the transaction

            // Check if the transaction status is false (failed)
            if ($db->transStatus() === false) {
                // Rollback and throw an exception if something went wrong
                throw new \Exception("Transaction failed, changes rolled back.");
            }

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            $db->transRollback();
            log_message('error', $e->getMessage()); // Log the error message
            return false; // Return false or handle error as needed
        }

        return true; // Return true if transaction succeeds
    }

}