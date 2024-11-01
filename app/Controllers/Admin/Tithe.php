<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Tithe extends WebController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\TithesModel();
    }
    
   
    public function index($parent_id = ''): string
    {
        if(!auth()->user()->canDo("$this->feature.read")){
            $page_data = $this->page_data(['errors' =>  []]);

            if ($this->request->isAJAX()) {
                return view("errors/html/error_403", $page_data);
            }

            return view('index', compact('page_data'));
        }

        $tithes = [];

        if($parent_id > 0){
            $tithes = $this->model->select('tithes.*,members.assembly_id as assembly_id,members.first_name as member_first_name,members.last_name as member_last_name')
            ->join('members','members.id = tithes.member_id','left')
            ->join('assemblies','assemblies.id=members.assembly_id','left')
            ->where('assembly_id',hash_id($parent_id,'decode'))
            ->orderBy('tithes.created_at desc')
            ->findAll();
        }else{
            $tithes = $this->model->select('tithes.*,members.assembly_id as assembly_id,members.first_name as member_first_name,members.last_name as member_last_name')
            ->join('assemblies','assemblies.id=members.assembly_id','left')
            ->join('members','members.id = tithes.member_id','left')
            ->orderBy('tithes.created_at desc')
            ->findAll();
        }
       
        if(!$tithes){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $tithes;
        }

        $page_data['result'] = $tithes;
        $page_data['feature'] = 'tithe';
        $page_data['action'] = 'list';
        
        if ($this->request->isAJAX()) {
            $page_data['parent_id'] = $parent_id;
            return view($this->session->user_type.'/tithe/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }   

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'member_id' => [
                'rules' =>'required',
                'label' => 'Member Name',
                'errors' => [
                    'required' => 'First Name is required.',
                ]
            ],
            'amount' => [
                'rules' =>'required',
                'label' => 'Tithe Amount',
                'errors' => [
                    'required' => 'Tithe Amount is required.',
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $hashed_assembly_id = $this->request->getPost('assembly_id');
        $assembly_id = hash_id($hashed_assembly_id, 'decode');

        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'amount' => $this->request->getPost('amount'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');

        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                log_message('error', json_encode($nonNullCustomFields));
                $customFieldLibrary->saveCustomFieldValues($insertId, $this->tableName, $customFieldValues);
            }
        }

        $this->parent_id = $hashed_assembly_id;

        if($this->request->isAJAX()){
            $this->feature = 'tithe';
            $this->action = 'list';
            $records = $this->model
            ->select('tithes.id,tithes.member_id,members.assembly_id as assembly_id,tithes.amount,members.first_name as member_first_name,members.last_name as member_last_name')
            ->join('members','members.id = tithes.member_id')
            ->join('assemblies','assemblies.id=members.assembly_id')
            ->orderBy("tithes.created_at desc")->where('assembly_id', $assembly_id)->findAll();

            $page_data = parent::page_data($records, $hashed_assembly_id);
            return view($this->session->user_type."/tithe/list", $page_data);
        }

        return redirect()->to(site_url($this->session->user_type."/tithes/view/".hash_id($insertId)));
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'member_id' => [
                'rules' =>'required',
                'label' => 'Member Name',
                'errors' => [
                    'required' => 'First Name is required.',
                ]
            ],
            'amount' => [
                'rules' =>'required',
                'label' => 'Tithe Amount',
                'errors' => [
                    'required' => 'Tithe Amount is required.',
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }
        
        $hashed_id = $this->request->getVar('id');
        $hashed_assembly_id = $this->request->getVar('assembly_id');

        $update_data = [
            'member_id' => $this->request->getPost('member_id'),
            'amount' => $this->request->getPost('amount'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');

        // Only save custom fields if they are not null
        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,dir: 'decode'), $this->tableName, $customFieldValues);
            }
        }

        $customFieldValuesInDB = $customFieldLibrary->getCustomFieldValuesForRecord(hash_id($hashed_id,dir: 'decode'), 'users');

        if($this->request->isAJAX()){
            $this->feature = 'tithe';
            $this->action = 'list';

            $records = $this->model
            ->select('tithes.id,tithes.member_id,members.assembly_id as assembly_id,tithes.amount,members.first_name as member_first_name,members.last_name as member_last_name')
            ->join('members','members.id = tithes.member_id')
            ->join('assemblies','assemblies.id=members.assembly_id')
            ->orderBy("tithes.created_at desc")
            ->where('assembly_id', hash_id($hashed_assembly_id,'decode'))
            ->findAll();
            return view($this->session->user_type."/tithe/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url($this->session->user_type."/tithe/view/".$hashed_id))->with('message', 'Tithe updated successfully!');
    }
}
