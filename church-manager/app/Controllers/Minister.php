<?php

namespace App\Controllers;

class Minister extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\MinistersModel();
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'number' => 'required|min_length[3]',
            'assembly_id'    => 'required|max_length[255]',
            'designation_id' => 'required|max_length[255]',
            'phone' => 'required|max_length[50]',
            'is_active' => 'required|min_length[3]|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'number' => $this->request->getPost('number'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'designation_id' => $this->request->getPost('designation_id'),
            'phone' => $this->request->getPost('phone'),
            'is_active' => $this->request->getPost('is_active'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), $update_data);

        if($this->request->isAJAX()){
            $this->feature = 'minister';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("minister/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("ministers/view/".$hashed_id))->with('message', 'Minister updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'number'    => 'required|min_length[3]',
            'assembly_id' => 'required|max_length[255]',
            'designation_id' => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'number' => $this->request->getPost('number'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'designation_id' => $this->request->getPost('designation_id'),
            'phone' => $this->request->getPost('phone'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'minister';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("minister/list", parent::page_data($records));
        }

        return redirect()->to(site_url("ministers/view/".hash_id($insertId)));
    }
}
