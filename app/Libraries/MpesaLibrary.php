<?php 

namespace App\Libraries;

class MpesaLibrary  implements \App\Interfaces\LibraryInterface {
    // Remove the interface and the MPesa controller after development is complete.
    private $client;
    private $base_url;
    function __construct(){
        $this->base_url = getenv('tunnellingDomain');
        $this->client = \Config\Services::curlrequest();
    }

    function express(string $denominationCode, string $payment_purpose, string $paying_number, int $amount){

        $endpoint = getenv('stkPushURL');
        $BusinessShortCode = getenv('shortCode');
        $passkey = getenv('passKey');
        $Timestamp = date('YmdHis'); 
        $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp); 
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = $amount;
        $PartyA = $paying_number;
        $PartyB = getenv('shortCode');
        $PhoneNumber = $paying_number;
        $CallBackURL = $this->base_url.'/callback/confirmation';
        $AccountReference = $denominationCode;
        $TransactionDesc = $payment_purpose;

        $body = compact(
            'BusinessShortCode',
            'Timestamp',
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

        $ch = curl_init(getenv('stkPushURL'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $this->access_token(),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response     = curl_exec($ch);
        curl_close($ch);
        // echo $response;

        return $response;

    }

    function access_token(){
        $response = $this->client->request(
        'GET',
        getenv('clientCredentialsURL'),
        [
                'auth' => [
                    getenv('consumerKey'),
                    getenv('consumerSecret')
                ],
                'http_errors' => false,
        ]
        );
       
        
        return json_decode($response->getBody())->access_token;
    }

    function register_urls(){
        $endpoint = getenv('registerURLs');

        $data = [
            'ShortCode' => getenv('shortCode'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $this->base_url.'/callback/pay_validation',
            'ValidationURL' => $this->base_url.'/callback/confirmation',
        ];

        $response = $this->client->request(
            'POST',
            $endpoint,
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->access_token(), 'PassKey' =>  getenv('passKey')],
                'json' => $data,
                'http_errors' => false,
                ]
            );

        return $response->getBody(); 
    }

    function registerUrls(){
        $ch = curl_init(getenv('registerURLs'));

        $data = [
            'ShortCode' => getenv('shortCode'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $this->base_url.'/callback/pay_validation',
            'ValidationURL' => $this->base_url.'/callback/confirmation',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.$this->access_token(),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response     = curl_exec($ch);
        curl_close($ch);
        return  $response;
    }

    // Interface methods to be removed later
    function unsetListQueryFields(){}

    function unsetViewQueryFields(){}

    function setListQueryFields(){
        $fields = [];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [];
        return $fields;
    }
}