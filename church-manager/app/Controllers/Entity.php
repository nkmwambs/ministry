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
        // log_message('error', json_encode(hash_id($hashed_id,'decode')));

        $entities = [];
        $hierarchy_id = hash_id($hashed_id,'decode');

        if($hashed_id != ''){
            $entities = $this->model
            ->where('entities.hierarchy_id', $hierarchy_id)
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy('entities.created_at desc')
            ->findAll();
        }else{
            $entities = $this->model
            ->where('entities.hierarchy_id', $hierarchy_id)
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy('entities.created_at desc')
            ->findAll();
        }

        // log_message('error', json_encode($entities));

        $page_data['result'] = $entities;
        $page_data['feature'] = 'entity';
        $page_data['action'] = 'list';

        if($this->request->isAJAX()){
            $page_data['id'] = $hashed_id;
            return view('entity/list', $page_data);
        }
        return view('index', $page_data);
    }

    public function add(): string {
        
        // if(method_exists($this->library, 'getLookUpItems')){
            // $page_data['lookup_items'] = $this->library->getLookUpItems(hash_id($this->feature_page_data["id"],'decode'));
        // }
        log_message('error', json_encode(hash_id($this->feature_page_data["id"],'decode')));
        $page_data['feature'] = 'entity';
        $page_data['action'] = 'add';
        $page_data['parent_entities'] = $this->model->where('hierarchy_id', hash_id($this->feature_page_data["id"],'decode'))->findAll();
        
        return view('entity/add', $page_data);
    }

    public function edit($id): string {
        $data = $this->model->getOne(hash_id($id,'decode'));
        $page_data = $this->page_data($data, $id);
        $page_data['parent_entities'] = [];
        return view('index', $page_data);
    }

    function post(){
        $insertId = 0;
        $hashed_hierarchy_id = $this->request->getVar('hierarchy_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' =>'required|min_length[5]|max_length[255]',
                'label' => 'Entity Name',
                'errors' => [
                   'required' => 'Entity Name is required.',
                   'min_length' => 'Entity Name must be at least {value} characters long.',
                   'max_length' => 'Entity Name cannot exceed {value} characters.'
                ]
            ],
            'entity_number' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'label' => 'Entity Number',
                'errors' => [
                    'required' => 'Entity Number is required.',
                    'min_length' => 'Entity Number must be at least {value} characters long.',
                    'max_length' => 'Entity Number cannot exceed {value} characters.',
                ]
            ],
            'parent_id' => [
                'rules' => 'required',
                'label' => 'Parent Entity',
                'errors' => [
                   'required' => 'Parent Entity is required.'
                ]
            ],
            'hierarchy_id' => [
                'rules' => 'required',
                'label' => 'Hierarchy Level',
                'errors' => [
                   'required' => 'Hierarchy Level is required.'
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'hierarchy_id' => hash_id($hashed_hierarchy_id, 'decode'),
            'entity_number' => $this->request->getPost('entity_number'),
            'parent_id' => $this->request->getPost('parent_id'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();
       

        if($this->request->isAJAX()){
            $this->feature = 'entity';
            $this->action = 'list';
            $records = $this->model
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy("entities.created_at desc")
            ->where('entities.hierarchy_id', hash_id($hashed_hierarchy_id,'decode'))->findAll();
            
            $page_data = parent::page_data($records);
            $page_data['id'] = $hashed_hierarchy_id;
            
            return view("entity/list", $page_data);
        }

        return redirect()->to(site_url("denominations/view/".hash_id($insertId)));
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');
        $hashed_hierarchy_id = $this->request->getVar('hierarchy_id');


        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' =>'required|min_length[5]|max_length[255]',
                'label' => 'Entity Name',
                'errors' => [
                   'required' => 'Entity Name is required.',
                   'min_length' => 'Entity Name must be at least {value} characters long.',
                   'max_length' => 'Entity Name cannot exceed {value} characters.'
                ]
            ],
            'entity_number' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'label' => 'Entity Number',
                'errors' => [
                    'required' => 'Entity Number is required.',
                    'min_length' => 'Entity Number must be at least {value} characters long.',
                    'max_length' => 'Entity Number cannot exceed {value} characters.',
                ]
            ],
            'parent_id' => [
                'rules' => 'required',
                'label' => 'Parent Entity',
                'errors' => [
                   'required' => 'Parent Entity is required.'
                ]
            ],
            'hierarchy_id' => [
                'rules' => 'required',
                'label' => 'Hierarchy Level',
                'errors' => [
                   'required' => 'Hierarchy Level is required.'
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }


        $update_data = [
            'name' => $this->request->getPost('name'),
            'hierarchy_id' => hash_id($hashed_hierarchy_id, 'decode'),
            'entity_number' => $this->request->getPost('entity_number'),
            'parent_id' => $this->request->getPost('parent_id'),
        ];

        // log_message('error', json_encode($validation->getErrors()));
        
        $this->model->update(hash_id($hashed_id,'decode'), $update_data);

        if($this->request->isAJAX()){
            $this->feature = 'entity';
            $this->action = 'list';
            $records = $this->model
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy("entities.created_at desc")
            ->where('entities.hierarchy_id', hash_id($hashed_hierarchy_id,'decode'))->findAll();
            
            $page_data = parent::page_data($records);
            $page_data['id'] = $hashed_hierarchy_id;
            
            return view("entity/list", $page_data);
        }
        
        return redirect()->to(site_url("entities/view/".$hashed_id))->with('message', 'Hierarchy updated successfully!');
    }

    function getParentEntitiesByDenomination($hashed_hierarchy_id, $parent_entity_id){

        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchyLevelObj = $hierarchyModel->where('id',hash_id($hashed_hierarchy_id,'decode'))->first();
        
        $upper_hierarchy_level = 1;
        $denomination_id = 0;

        if($hierarchyLevelObj){
            $upper_hierarchy_level = $hierarchyLevelObj['level'] - 1;
            $denomination_id = $hierarchyLevelObj['denomination_id'];
        }

        $parent_entities = $this->model
        ->where('level', $upper_hierarchy_level)
        ->where('denomination_id', $denomination_id)
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
