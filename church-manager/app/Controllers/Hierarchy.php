<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Hierarchy extends BaseController
{
    private $model = null;
    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\HierarchiesModel();
    }

    function ajax_index(){
        $hierarchies = $this->model->select('id,name,denomination_id,level')->findAll();
       
        if(!$hierarchies){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $hierarchies;
        }

        $page_data['result'] = $hierarchies;
        // $page_data['feature'] = 'hierarchy';
        // $page_data['action'] = 'list';

        return view('hierarchy/list', $page_data);
    }
    public function index(): string
    {
        $hierarchies = $this->model->select('id,name,denomination_id,level')->findAll();
       
        if(!$hierarchies){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $hierarchies;
        }

        $page_data['result'] = $hierarchies;
        $page_data['feature'] = 'hierarchy';
        $page_data['action'] = 'list';

        return view('index', $page_data);
    }
}
