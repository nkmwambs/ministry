<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;

class Payment extends WebController
{
    // public function index()
    // {
    //     //
    // }

    function postStk(){
        $data = $this->request->getJSON();

        log_message('error', json_encode($data));
        
        return $this->response->setStatusCode(200)->setJSON(['ResponseCode' => 0]);
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
