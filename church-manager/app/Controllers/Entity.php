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

    function post(){
        $insertId = 0;

        // $validation = \Config\Services::validation();
        // $validation->setRules([
        //     'name' => 'required|min_length[10]|max_length[255]',
        //     'email'    => 'required|valid_email|max_length[255]',
        //     'code' => 'required|min_length[3]',
        // ]);

        // if (!$this->validate($validation->getRules())) {
        //     return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        // }

        $denomination_id = hash_id($this->request->getPost('denomination_id'),'decode');

        $data = [
            'name' => $this->request->getPost('name'),
            'denomination_id' => $denomination_id,
            'description' => $this->request->getPost('description'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'hierarchy';
            $this->action = 'list';
            $records = $this->model->orderBy("created_at desc")->where('denomination_id', $denomination_id)->findAll();
            $page_data = parent::page_data($records);
            $page_data['id'] = hash_id($denomination_id,'encode');
            // log_message('error', json_encode($page_data));
            return view("hierarchy/list", $page_data);
        }

        return redirect()->to(site_url("denominations/view/".hash_id($insertId)));
    }

    function getParentEntitiesByDenomination($hashed_denomination_id, $hierarchy_id){

        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchyLevelObj = $hierarchyModel->where('id',$hierarchy_id)->first();
        
        $upper_hierarchy_level = 1;

        if($hierarchyLevelObj){
            $upper_hierarchy_level = $hierarchyLevelObj['level'] - 1;
        }

        $parent_entities = $this->model
        ->where('level', $upper_hierarchy_level)
        ->where('denomination_id', hash_id($hashed_denomination_id,'decode'))
        ->join('hierarchies', 'hierarchies.id=entities.hierarchy_id')
        ->select('entities.id,hierarchy_id,entity_number,entities.name,parent_id,entity_leader')
        ->findAll();

        $rst = [];

        if($parent_entities){
            $rst = $parent_entities; 
        }

        return json_encode($rst);
    }
}
