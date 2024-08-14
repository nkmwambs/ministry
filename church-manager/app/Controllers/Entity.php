<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Entity extends BaseController
{
    private $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\EntitiesModel();
    }
    public function index(): string
    {
        $entities = $this->model->select('id,name,code,registration_date,email,phone,head_office')->findAll();

        $page_data['result'] = $entities;
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'list';
        return view('index', $page_data);
    }
}
