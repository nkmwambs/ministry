<?php

namespace App\Controllers;

use App\Controllers\WebController;


class Callback extends WebController
{

    // function postStk(){
    //     // $res = $this->request->getJSON();

    //     $res = '{
    //             "Body": {
    //                 "stkCallback": {
    //                     "MerchantRequestID": "8ed5-4489-a67f-881890b925f2938781",
    //                     "CheckoutRequestID": "ws_CO_07102024140157946711808071",
    //                     "ResultCode": 0,
    //                     "ResultDesc": "The service request is processed successfully.",
    //                     "CallbackMetadata": {
    //                         "Item": [
    //                             {
    //                                 "Name": "Amount",
    //                                 "Value": 1
    //                             },
    //                             {
    //                                 "Name": "MpesaReceiptNumber",
    //                                 "Value": "SJ778V66XN"
    //                             },
    //                             {
    //                                 "Name": "TransactionDate",
    //                                 "Value": 20241007140146
    //                             },
    //                             {
    //                                 "Name": "PhoneNumber",
    //                                 "Value": 254711808071
    //                             }
    //                         ]
    //                     }
    //                 }
    //             }
    //         }';

    //     // $responseObj = json_decode($res, true);

    //     // log_message('error', $responseObj);

    //     log_message('error', 'Hello World');

    //     return $this->response->setJSON(["message" => "Hello World"]);

    //     // $responseValues = $responseObj['Body']['stkCallback'];
    //     // $items = $responseObj['Body']['stkCallback']['CallbackMetadata']['Item'];

    //     // $itemNames = array_column($items, 'Name');
    //     // $itemValues  = array_column($items, 'Value');
    //     // $nameValues = array_combine($itemNames, $itemValues);

    //     // $payment_status = $responseValues['ResultCode'] == 0 ? 'success' : 'failed';
    //     // $payment_code = $responseValues['ResultCode'] == 0 ? $nameValues['MpesaReceiptNumber'] : NULL;
    //     // $participant_status = $responseValues['ResultCode'] == 0 ? 'registered' : 'failed';

    //     //  // Load necessary models
    //     // $paymentModel = new \App\Models\PaymentsModel();
    //     // $participantModel = new \App\Models\ParticipantsModel();

    //     // $payment = (object)$paymentModel->where('MerchantRequestID', $responseValues['MerchantRequestID'])->first();
    //     // $payment->payment_status = $payment_status;
    //     // $payment->payment_code = $payment_code;
    //     // $paymentModel->save($payment);

    //     // $participant = (object)$participantModel->where('payment_id', $payment->id)->first();
    //     // $participant->status = $participant_status;
    //     // $participantModel->save($participant);
        
    //     // return $this->response->setStatusCode(200)->setJSON($responseObj);
    // }

    function postConfirmation(){
        $data = $this->request->getJSON();
        log_message('error', json_encode($data));
        return $this->response->setJSON(['message' => 'Hello World!!']);
    }

    function postPay_validation(){
        log_message('error', 'Validate');
        $data = $this->request->getJSON();
        return $this->response->setJSON(['message' => 'Hello']);
    }
}
