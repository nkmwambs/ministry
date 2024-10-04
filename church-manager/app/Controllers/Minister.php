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
            // 'minister_number' => 'required|min_length[3]',
            'is_active' => 'required|min_length[2]|max_length[3]',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            // 'minister_number' => $this->request->getPost('minister_number'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'designation_id' => $this->request->getPost('designation_id'),
            'phone' => $this->request->getPost('phone'),
            'is_active' => $this->request->getPost('is_active'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,'decode'), $this->tableName, $customFieldValues);

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
            // 'minister_number' => 'required|min_length[3]',
            'is_active' => 'required|min_length[2]|max_length[3]',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        // $hashed_denomination_id = $this->request->getPost('denomination_id');
        $assembly_id = $this->request->getPost('assembly_id');//hash_id($hashed_denomination_id, 'decode');

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        $customFieldLibrary->saveCustomFieldValues($insertId, $this->tableName, $customFieldValues);

        $data = [
            'name' => $this->request->getPost('name'),
            'minister_number' => $this->computeMinisterNumber(),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'designation_id' => $this->request->getPost('designation_id'),
            'phone' => $this->request->getPost('phone'),
            'is_active' => $this->request->getPost('is_active'),
        ];

        $this->model->insert((object)$data);
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

        return redirect()->to(site_url("ministers/view/".hash_id($insertId)))->with('message', 'Minister added seccessfuly!');;
    }

    private function computeMinisterNumber() {
        $ministerNumber = '';

        $ministerCount = $this->model->countAllResults();
        ++$ministerCount;

        $ministerCount = str_pad($ministerCount,4,'0',STR_PAD_LEFT);

        while ($this->model->where('minister_number', $ministerNumber)->countAllResults() > 0) {
            ++$ministerCount;
            $ministerNumber = "MIN/$ministerCount";
        }

        return $ministerNumber;
    }
}
