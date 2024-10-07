<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Callback extends BaseController
{
    public function index()
    {
        return "Welcome Home";
    }

    // function getStk(){
    //     $data = $this->request->getJSON();

    //     log_message('error', json_encode($data));
    // }

    function postStk(){
        // $res = $this->request->getJSON();

        $res = '{
                "Body": {
                    "stkCallback": {
                        "MerchantRequestID": "8ed5-4489-a67f-881890b925f2938781",
                        "CheckoutRequestID": "ws_CO_07102024140157946711808071",
                        "ResultCode": 0,
                        "ResultDesc": "The service request is processed successfully.",
                        "CallbackMetadata": {
                            "Item": [
                                {
                                    "Name": "Amount",
                                    "Value": 1
                                },
                                {
                                    "Name": "MpesaReceiptNumber",
                                    "Value": "SJ778V66XN"
                                },
                                {
                                    "Name": "TransactionDate",
                                    "Value": 20241007140146
                                },
                                {
                                    "Name": "PhoneNumber",
                                    "Value": 254711808071
                                }
                            ]
                        }
                    }
                }
            }';

        $responseObj = json_decode($res, true);

        $responseValues = $responseObj['Body']['stkCallback'];
        $items = $responseObj['Body']['stkCallback']['CallbackMetadata']['Item'];

        $itemNames = array_column($items, 'Name');
        $itemValues  = array_column($items, 'Value');
        $nameValues = array_combine($itemNames, $itemValues);

        // return $this->response->setStatusCode(200)->setJSON($nameValues););

        $payment_status = $responseValues['ResultCode'] == 0 ? 'success' : 'failed';
        $payment_code = $responseValues['ResultCode'] == 0 ? $nameValues['MpesaReceiptNumber'] : NULL;
        $participant_status = $responseValues['ResultCode'] == 0 ? 'registered' : 'failed';

         // Load necessary models
        $paymentModel = new \App\Models\PaymentsModel();
        $participantModel = new \App\Models\ParticipantsModel();

        $payment = (object)$paymentModel->where('MerchantRequestID', $responseValues['MerchantRequestID'])->first();
        log_message('error', json_encode($payment));
        $payment->payment_status = $payment_status;
        $payment->payment_code = $payment_code;
        $paymentModel->save($payment);

        $participant = (object)$participantModel->where('payment_id', $payment->id)->first();
        $participant->status = $participant_status;
        $participantModel->save($participant);
        
        return $this->response->setStatusCode(200)->setJSON($responseObj);
    }

    function getConfirmation(){
        $data = $this->request->getJSON();
        log_message('error', json_encode($data));
        return "Hello";
    }

    function getPay_validation(){
        $data = $this->request->getJSON();
        log_message('error', json_encode($data));
    }
}
