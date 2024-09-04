<?php

namespace App\Controllers;

class Denomination extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\DenominationsModel();
    }

    public function index()
    {
        $data = [];

        if(!session()->get('user_denomination_id')){
            if(method_exists($this->model, 'getAll')){
                $data = $this->model->getAll();
            }else{
                $data = $this->model->findAll();
            }
        }else{
            $data = $this->model->where('id', session()->get('user_denomination_id'))->findAll();
        }
        

        if ($this->request->isAJAX()) {
            // $page_data['id'] = $id;
            $page_data = $this->page_data($data);
            return view("$this->feature/list", $page_data);
        }

        return view('index', $this->page_data($data));
    }

    public function view($id): string {
        $data = $this->model->getOne(hash_id($id,'decode'));
        if(array_key_exists('id',$data)){
            unset($data['id']);
        }

        $hierarchyModel = new \App\Models\HierarchiesModel();
        $data['other_details'] = $hierarchyModel->where('denomination_id', hash_id($id,'decode'))->where('level <>', 1)->findAll();
        
        $this->parent_id = $id;

        $page_data = parent::page_data($data);
    
        return view('index', $page_data);
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'email'    => 'required|valid_email|max_length[255]',
            'code' => 'required|min_length[3]',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'registration_date' => $this->request->getPost('registration_date'),
            'email' => $this->request->getPost('email'),
            'head_office' => $this->request->getPost('head_office'),
            'phone' => $this->request->getPost('phone'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        if($this->request->isAJAX()){
            $this->feature = 'denomination';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("denomination/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("denominations/view/".$hashed_id))->with('message', 'Denomination updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]',
            'email'    => 'required|valid_email|max_length[255]',
            'code' => 'required|min_length[3]',
        ]);

        
        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
           'registration_date' => $this->request->getPost('registration_date'),
            'email' => $this->request->getPost('email'),
            'head_office' => $this->request->getPost('head_office'),
            'phone' => $this->request->getPost('phone'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'denomination';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("denomination/list", parent::page_data($records));
        }

        return redirect()->to(site_url("denominations/view/".hash_id($insertId)));
    }
}
