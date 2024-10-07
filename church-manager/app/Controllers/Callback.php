<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Callback extends BaseController
{
    public function index()
    {
        //
    }

    function postStk(){
        $data = $this->request->getBody();

        log_message('error', json_encode($data));

        // $data_array = json_decode($data, true);

        // $res = `{    
        //     "Body": {        
        //        "stkCallback": {            
        //           "MerchantRequestID": "29115-34620561-1",            
        //           "CheckoutRequestID": "ws_CO_191220191020363925",            
        //           "ResultCode": 0,            
        //           "ResultDesc": "The service request is processed successfully.",            
        //           "CallbackMetadata": {                
        //              "Item": [{                        
        //                 "Name": "Amount",                        
        //                 "Value": 1.00                    
        //              },                    
        //              {                        
        //                 "Name": "MpesaReceiptNumber",                        
        //                 "Value": "NLJ7RT61SV"                    
        //              },                    
        //              {                        
        //                 "Name": "TransactionDate",                        
        //                 "Value": 20191219102115                    
        //              },                    
        //              {                        
        //                 "Name": "PhoneNumber",                        
        //                 "Value": 254708374149                    
        //              }]            
        //           }        
        //        }    
        //     }
        //  }`;

        //  // Update participants information
        //  $stk_status_code = $data_array['stkCallback']['ResultCode'];

        //  $payment_status = $stk_status_code == 0 ? 'success' : 'failed';
        //  $participant_status = $stk_status_code == 0 ? 'registered' : 'failed';

        //  $details = $data_array['stkCallback']['CallbackMetadata']['Item'];

        //  $names = array_column($details, 'Name');
        //  $values = array_column($details, 'Value');

        //  $newData = array_combine($names, $values);

        //  // Load necessary models
        // $paymentModel = new \App\Models\PaymentsModel();
        // $participantModel = new \App\Models\ParticipantsModel();

        // $payment = $paymentModel->where('MerchantRequestID', $newData['MerchantRequestID'])->first();
        // $payment->payment_status = $payment_status;
        // $payment->payment_code = $stk_status_code == 0 ? $newData['MpesaReceiptNumber'] : NULL;
        // $paymentModel->save($payment);

        // $participant = $participantModel->where('payment_id', $payment['id'])->first();
        // $participant->status = $participant_status;
        // $participantModel->save($participant);
        
        // return $this->response->setStatusCode(200)->setJSON($data);
    }

    function getConfirmation(){
        $data = $this->request->getJSON();
        log_message('error', json_encode($data));
    }

    function getPay_validation(){
        $data = $this->request->getJSON();
        log_message('error', json_encode($data));
    }
}
