<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Hierarchy extends BaseController
{
    protected $model = null;
    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\HierarchiesModel();
    }
    public function index($id = 0): string
    {
        $hierarchies = [];

        if($id > 0){
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, level')
            ->where('denomination_id',hash_id($id,'decode'))
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->findAll();
        }else{
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, level')
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->findAll();
        }
       
        if(!$hierarchies){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $hierarchies;
        }

        $page_data['result'] = $hierarchies;
        $page_data['feature'] = 'hierarchy';
        $page_data['action'] = 'list';

        if ($this->request->isAJAX()) {
            return view('hierarchy/list', $page_data);
        }

        return view('index', $page_data);
    }

    public function add(): string {
        $page_data['feature'] = 'hierarchy';
        $page_data['action'] = 'add';
        return view('index', $page_data);
    }
}
