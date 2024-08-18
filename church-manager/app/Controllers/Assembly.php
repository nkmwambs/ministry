<?php

namespace App\Controllers;

class Assembly extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\AssembliesModel();
    }

    public function view($id): string {
        $data = $this->model->getOne(hash_id($id,'decode'));
        if(array_key_exists('id',$data)){
            unset($data['id']);
        }

        $hierarchyModel = new \App\Models\HierarchiesModel();
        $data['other_details'] = $hierarchyModel->where('assembly_id', hash_id($id,'decode'))->where('level <>', 1)->findAll();

        $page_data = parent::page_data($data, $id);
    
        return view('index', $page_data);
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'entity_id'    => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'planted_at' => $this->request->getPost('planted_at'),
            'location' => $this->request->getPost('location'),
            'entity_id' => $this->request->getPost('entity_id'),
            'assembly_leader' => $this->request->getPost('assembly_leader'),
            'is_active' => $this->request->getPost('is_active'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), $update_data);

        if($this->request->isAJAX()){
            $this->feature = 'assembly';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("assembly/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("assembly/view/".$hashed_id))->with('message', 'Assembly updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'entity_id'    => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'planted_at' => $this->request->getPost('planted_at'),
            'location' => $this->request->getPost('location'),
            'entity_id' => $this->request->getPost('entity_id'),
            'assembly_leader' => $this->request->getPost('assembly_leader'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'assembly';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("assembly/list", parent::page_data($records));
        }

        return redirect()->to(site_url("assemblies/view/".hash_id($insertId)));
    }
}
