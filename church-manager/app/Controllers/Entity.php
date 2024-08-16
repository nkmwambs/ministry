<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Entity extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\EntitiesModel();
    }
    public function index($hashed_id = ''): string
    {
        $entities = [];
        $hierarchy_id = hash_id($hashed_id,'decode');

        if($hashed_id != ''){
            $entities = $this->model
            ->where('hierarchy_id', $hierarchy_id)
            ->select('id,hierarchy_id,entity_number,name,parent_id,entity_leader')
            ->findAll();
        }else{
            $entities = $this->model
            ->where('hierarchy_id', $hierarchy_id)
            ->select('id,hierarchy_id,entity_number,name,parent_id,entity_leader')
            ->findAll();
        }

        $page_data['result'] = $entities;
        $page_data['feature'] = 'entity';
        $page_data['action'] = 'list';

        if($this->request->isAJAX()){
            $page_data['id'] = $hashed_id;
            return view('entity/list', $page_data);
        }
        return view('index', $page_data);
    }
}
