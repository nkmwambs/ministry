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
    
        $denomination = $this->model->select('name,code,registration_date,head_office,email,phone')
        ->where('id', hash_id($id,'decode'))
        ->first();
     
        $page_data['result'] = $denomination;
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'view';
        $page_data['id'] = $id;
        return view('index', $page_data);
    }

    public function edit($id): string {
        $denomination = $this->model->select('id,name,code,registration_date,head_office,email,phone')
        ->where('id', hash_id($id,'decode'))
        ->first();

        $page_data['result'] = $denomination;
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'edit';
        return view('index', $page_data);
    }

    public function update(){

        $id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'email'    => 'required|valid_email|max_length[255]',
            'code' => 'required|min_length[3]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'registration_date' => $this->request->getPost('registration_date'),
            'email' => $this->request->getPost('email'),
            'head_office' => $this->request->getPost('head_office'),
            'phone' => $this->request->getPost('phone'),
        ];
        
        $this->model->update(hash_id($id,'decode'), $data);

        return redirect()->to(site_url("denominations/view/".$id))->with('message', 'Denomination updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'email'    => 'required|valid_email|max_length[255]',
            'code' => 'required|min_length[3]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
           'registration_date' => $this->request->getPost('registration_date'),
            'email' => $this->request->getPost('email'),
            'head_office' => $this->request->getPost('head_office'),
            'phone' => $this->request->getPost('phone'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        return redirect()->to(site_url("denominations/view/".hash_id($insertId)));
    }
}
