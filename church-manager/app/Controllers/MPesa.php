<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MPesa extends BaseController
{
    private $client;
    private $base_url;
    function __construct(){
        $this->base_url = 'https://daba-196-223-167-234.ngrok-free.app';
        $this->client = \Config\Services::curlrequest();
    }
    public function getIndex()
    {
        echo "Welcome to Mpesa!!!";
    }

    function getExpress($paying_number, $amount){
        
        $endpoint = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $BusinessShortCode = '174379';
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $Timestamp = date('YmdHis'); // '20240924115834'; 
        $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp); // "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjQwOTI0MTE1ODM0"; 
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = $amount;
        $PartyA = $paying_number;
        $PartyB = '174379';
        $PhoneNumber = $paying_number;
        $CallBackURL = $this->base_url.'/payment/stk';
        $AccountReference = 'CompanyXLTD';
        $TransactionDesc = 'Payment of X';

        $body = compact(
            'BusinessShortCode',
            'Timestamp',
            'Password',
            'Password',
            'TransactionType',
            'Amount',
            'PartyA',
            'PartyB',
            'PhoneNumber',
            'CallBackURL',
            'AccountReference',
            'TransactionDesc',
        );

        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $this->getAccess_token(),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response     = curl_exec($ch);
        curl_close($ch);
        // echo $response;
        
        log_message('error', json_encode($response));

        return $this->response->setJSON($response);

    }

    function getAccess_token(){
        $response = $this->client->request(
        'GET',
        'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
        [
                'auth' => [
                    'Akp17hzerzyCz5gQMG5ze7gMMj0AAGECFe7JzApM7iotOFIa',
                    'pcfwKtR5AZGYwymmjsPuYInUkEY5wm60F22MNQif4hBMaktTyGx1XpUJegGRLL6J'
                ],
                'http_errors' => false,
        ]
        );
       
        
        return json_decode($response->getBody())->access_token;
    }
}
