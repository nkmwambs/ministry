<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Dashboard extends WebController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // log_message('error', json_encode($this->session->get()));
    }
    
}
