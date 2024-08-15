<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    private $model = null;
    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\UsersModel();
    }
    public function index()
    {
        $users = $this->model->select('id,first_name,last_name,phone,email,is_active')
        ->findAll();

        if(!$users){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $users;
        }
        
        $page_data['feature'] = 'user';
        $page_data['action'] = 'list';
        return view('index', $page_data);
    }

    public function add($id = 0): string {
        $page_data['feature'] = 'user';
        $page_data['action'] = 'add';
        return view('index', $page_data);
    }
}
