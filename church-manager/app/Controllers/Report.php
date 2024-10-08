<?php

namespace App\Controllers;

use \CodeIgniter\HTTP\ResponseInterface;

class Report extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\ReportsModel();
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'report_period' => 'required',
            'report_date' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $update_data = [
            'reports_type_id' => $this->request->getPost('reports_type_id'),
            'report_period' => $this->request->getPost('report_period'),
            'report_date' => $this->request->getPost('report_date'),
            'status' => $this->request->getPost('status'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,'decode'), $this->tableName, $customFieldValues);

        if($this->request->isAJAX()){
            $this->feature = 'report';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("report/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("reports/view/".$hashed_id))->with('message', 'Report updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'report_period' => 'required',
            'report_date' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        // $customFieldLibrary = new \App\Libraries\FieldLibrary();
        // $customFieldValues = $this->request->getPost('custom_fields');
        // $customFieldLibrary->saveCustomFieldValues($insertId, $this->tableName, $customFieldValues);

        $data = [
            'reports_type_id' => $this->request->getPost('reports_type_id'),
            'report_period' => $this->request->getPost('report_period'),
            'report_date' => $this->request->getPost('report_date'),
            'status' => $this->request->getPost('status'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'report';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("report/list", parent::page_data($records));
        }

        return redirect()->to(site_url("report/view/".hash_id($insertId)))->with('message', 'Report added seccessfuly!');;
    }
}
