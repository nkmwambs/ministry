<?php

namespace App\Controllers;

use App\Controllers\WebController;

class MPesa extends WebController
{
    private $client;
    private $base_url;
    function __construct(){
        $this->base_url = 'https://e9c9-197-232-60-104.ngrok-free.app';
        $this->client = \Config\Services::curlrequest();
    }
    public function getIndex()
    {
        echo "Welcome to Mpesa!!!";
    }

    function getExpress(string $paying_number, int $amount){
        
        $endpoint = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $BusinessShortCode = '4146601';
        $passkey = "7ce5d0234d846f90f3fd96cc370682974151587fb3cc980ca9924b3d2c8af7e0";
        $Timestamp = date('YmdHis'); // '20240924115834'; 
        $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp); // "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjQwOTI0MTE1ODM0"; 
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = $amount;
        $PartyA = $paying_number;
        $PartyB = '4146601';
        $PhoneNumber = $paying_number;
        $CallBackURL = $this->base_url.'/callback/stk';
        $AccountReference = 'CHURCH MONTHLY RETURNS';
        $TransactionDesc = 'Payment of Monthly Returns';

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

        $ch = curl_init('https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
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
        
        return $this->response->setJSON($response);

    }

    function getAccess_token(){
        $response = $this->client->request(
        'GET',
        'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
        [
                'auth' => [
                    'YinBARfRAiYIpl30p9VQEB5uTNSR4AhO0WKDIN47bGAV2WYA',
                    '7RsGrWaQgfYn19AAhdtpE8A71T3w86JdgZ7ycU28rdS2YFaeo54mHdZHTVMgOXJO'
                ],
                'http_errors' => false,
        ]
        );
       
        
        return json_decode($response->getBody())->access_token;
    }

    function getRegister_urls(){
        $endpoint = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $data = [
            'validationURL' => $this->base_url.'/callback/confirmation',
            'confirmationURL' => $this->base_url.'/callback/pay_validation',
            'responseType' => 'completed',
            'shortCode' => '4146601'
        ];

        $response = $this->client->request(
            'POST',
            $endpoint,
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->getAccess_token()],
                'json' => $data,
                'http_errors' => false,
                ]
            );

        return response()->setJSON($response->getBody());
    }

}

