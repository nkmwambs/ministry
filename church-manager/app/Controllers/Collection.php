<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Collection extends BaseController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\CollectionsModel();
    }

    public function index($parent_id = 0): string
    {
        $collections = [];

        if($parent_id > 0){
            $collections = $this->model->select('collections.id,return_date,period_start_date,period_end_date,assembly_id,revenue_id,amount,status,collection_reference,description,collection_method')
            ->where('assembly_id',hash_id($parent_id,'decode'))
            ->join('assemblies','assemblies.id=collections.assembly_id')
            ->orderBy('collections.created_at desc')
            ->findAll();
        }else{
            $collections = $this->model->select('collections.id,return_date,period_start_date,assembly_id,period_end_date,revenue_id,amount,status,collection_reference,description,collection_method')
            ->join('assemblies','assemblies.id=collections.assembly_id')
            ->orderBy('collections.created_at desc')
            ->findAll();
        }

        log_message('error', json_encode($collections));
       
        if(!$collections){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $collections;
        }

        $page_data['result'] = $collections;
        $page_data['feature'] = 'collection';
        $page_data['action'] = 'list';
        
        if ($this->request->isAJAX()) {
            $page_data['parent_id'] = $parent_id;
            return view('collection/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'return_date' => 'required',
            'period_start_date' => 'required',
            'period_end_date' => 'required',
            'revenue_id' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'collection_reference' => 'required',
            'description' => 'required|min_length[10]',
            'collection_method' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $hashed_assembly_id = $this->request->getPost('assembly_id');
        $assembly_id = hash_id($hashed_assembly_id, 'decode');

        $data = [
            'return_date' => $this->request->getPost('return_date'),
            'period_start_date' => $this->request->getPost('period_start_date'),
            'period_end_date' => $this->request->getPost('period_end_date'),
            'assembly_id' => $assembly_id,
            'revenue_id' => $this->request->getPost('revenue_id'),
            'amount' => $this->request->getPost('amount'),
            'status' => $this->request->getPost('status'),
            'collection_reference' => $this->request->getPost('collection_reference'),
            'description' => $this->request->getPost('description'),
            'collection_method' => $this->request->getPost('collection_method'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        $customFieldLibrary->saveCustomFieldValues(hash_id($insertId,'decode'), $this->tableName, $customFieldValues);

        $this->parent_id = $hashed_assembly_id;

        if($this->request->isAJAX()){
            $this->feature = 'collection';
            $this->action = 'list';
            $records = $this->model->select('return_date,period_start_date,period_end_Date,assembly_id,assemblies.name as assembly_name,revenue_id,revenues.name as revenue_name,designations.amount,designations.status,collection_reference,designations.description,collection_method')
            ->join('assemblies', 'assemblies.id = designations.assembly_id')
            ->join('revenues', 'revenues.id = designations.revenue_id')
            ->orderBy("designations.created_at desc")
            ->where('assembly_id', $assembly_id)
            ->findAll();
            
            $page_data = parent::page_data($records, $hashed_assembly_id);

            return view("collection/list", $page_data);
        }

        return redirect()->to(site_url("collections/view/".hash_id($insertId)));
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'return_date' => 'required',
            'period_start_date' => 'required',
            'period_end_date' => 'required',
            'revenue_id' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'collection_reference' => 'required',
            'description' => 'required|min_length[10]',
            'collection_method' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }
        
        $hashed_id = $this->request->getVar('id');
        $hashed_assembly_id = $this->request->getVar('assembly_id');

        $update_data = [
            'return_date' => $this->request->getPost('return_date'),
            'period_start_date' => $this->request->getPost('period_start_date'),
            'period_end_date' => $this->request->getPost('period_end_date'),
            'revenue_id' => $this->request->getPost('revenue_id'),
            'amount' => $this->request->getPost('amount'),
            'status' => $this->request->getPost('status'),
            'collection_reference' => $this->request->getPost('collection_reference'),
            'description' => $this->request->getPost('description'),
            'collection_method' => $this->request->getPost('collection_method'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,'decode'), $this->tableName, $customFieldValues);

        if($this->request->isAJAX()){
            $this->feature = 'collection';
            $this->action = 'list';

            $records = $this->model->select('return_date,period_start_date,period_end_Date,assembly_id,assemblies.name as assembly_name,revenue_id,revenues.name as revenue_name,designations.amount,designations.status,collection_reference,designations.description,collection_method')
            ->join('assemblies', 'assemblies.id = designations.assembly_id')
            ->join('revenues', 'revenues.id = designations.revenue_id')
            ->orderBy("designations.created_at desc")
            ->where('assembly_id', hash_id($hashed_assembly_id, 'decode'))
            ->findAll();
            return view("collection/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("collection/view/".$hashed_id))->with('message', 'Collection updated successfully!');
    }

    // private function computeNextHierarchicalLevel($denomination_id){
    //     $maxLevel = $this->model->selectMax('level')->where('denomination_id', $denomination_id)->first();
    //     return $maxLevel['level'] + 1;
    // }
}
