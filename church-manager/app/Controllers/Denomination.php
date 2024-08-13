<?php

namespace App\Controllers;

class Denomination extends BaseController
{
    private $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\DenominationsModel();
    }
    public function index(): string
    {
        $denominations = $this->model->select('id,name,code,registration_date,email,phone,head_office')->findAll();

        $page_data['result'] = $denominations;
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'list';
        return view('index', $page_data);
    }

    public function add(): string {
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'add';
        return view('index', $page_data);
    }

    public function view($id): string {
        $denomination = $this->model->find(hash_id($id,'decode'));

        $page_data['result'] = $denomination;
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'view';
        return view('index', $page_data);
    }

    public function edit($id): string {
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'edit';
        return view('index', $page_data);
    }
}
