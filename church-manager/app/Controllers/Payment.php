<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Payment extends BaseController
{
    public function index()
    {
        //
    }

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
