<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Member extends BaseController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\MembersModel();
    }
    
   
    public function index($parent_id = ''): string
    {
        $members = [];

        if($parent_id > 0){
            $members = $this->model->select('members.id,first_name,gender,last_name,assembly_id,assemblies.name as assembly_name,member_number,designations.name as designation_name,designation_id,date_of_birth,email,phone')
            ->where('assembly_id',hash_id($parent_id,'decode') )
            ->join('assemblies','assemblies.id=members.assembly_id','left')
            ->join('designations','designations.id = members.designation_id')
            ->orderBy('members.created_at desc')
            ->findAll();
        }else{
            $members = $this->model->select('members.id,first_name,gender,last_name,assembly_id,member_number,designations.name as designation_name,designation_id,date_of_birth,email,phone')
            ->join('assemblies','assemblies.id=members.assembly_id','left')
            ->join('designations','designations.id = members.designation_id')
            ->orderBy('members.created_at desc')
            ->findAll();
        }
       
        if(!$members){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $members;
        }

        $page_data['result'] = $members;
        $page_data['feature'] = 'member';
        $page_data['action'] = 'list';
        
        if ($this->request->isAJAX()) {
            $page_data['parent_id'] = $parent_id;
            // log_message('error',hash_id($parent_id,'decode'));
            return view('member/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }   

    function post(){
        $insertId = 0;
        // $hashed_assembly_id = $this->request->getVar('assembly_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => [
                'rules' =>'required|min_length[3]|max_length[255]',
                'label' => 'First Name',
                'errors' => [
                    'required' => 'First Name is required.',
                    'min_length' => 'First Name must be at least {value} characters long.',
                ]
            ],
            'last_name' => [
                'rules' =>'required|min_length[3]|max_length[255]',
                'label' => 'Last Name',
                'errors' => [
                    'required' => 'Last Name is required.',
                    'min_length' => 'Last Name must be at least {value} characters long.',
                ]
            ],
            'gender' => [
                'rules' =>'required',
                'label' => 'Member.member_gender',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'date_of_birth' => [
                'rules' => 'required',
                'label' => 'Date of Birth',
                'errors' => [
                    'required' => 'Date of Birth is required.',
                ]
            ],
            'phone' => [
                'rules' => 'required|regex_match[/^\+254\d{9}$/]',
                'label' => 'Phone',
                'errors' => [
                    'regex_match' => 'Phone number should be in the format +254XXXXXXXX',
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $hashed_assembly_id = $this->request->getPost('assembly_id');
        $assembly_id = hash_id($hashed_assembly_id, 'decode');
        // $parent_id = $this->request->getPost('parent_id');
        // log_message('error', $assembly_id);

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'gender' => $this->request->getPost('gender'),
            'assembly_id' => $assembly_id,
            'member_number' => $this->computeMemberNumber($assembly_id),
            'designation_id' => $this->request->getPost('designation_id'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();
        // log_message('error', $insertId);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        // $customFieldLibrary->saveCustomFieldValues(hash_id($insertId,'decode'), $this->tableName, $customFieldValues);

        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                $customFieldLibrary->saveCustomFieldValues(hash_id($insertId,'decode'), $this->tableName, $customFieldValues);
            }
        }

        $this->parent_id = $hashed_assembly_id;

        if($this->request->isAJAX()){
            $this->feature = 'member';
            $this->action = 'list';
            $records = $this->model
            ->select('members.id,first_name,gender,last_name,assembly_id,assemblies.name as assembly_name,member_number,designations.name as designation_name,designation_id,date_of_birth,email,phone')
            ->join('designations','designations.id=members.designation_id')
            ->join('assemblies','assemblies.id=members.assembly_id')
            ->orderBy("members.created_at desc")->where('assembly_id', $assembly_id)->findAll();

            $page_data = parent::page_data($records, $hashed_assembly_id);
            // $page_data['parent_id'] = hash_id($assembly_id,'encode');
            return view("member/list", $page_data);
        }

        return redirect()->to(site_url("members/view/".hash_id($insertId)));
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => [
                'rules' =>'required|min_length[3]|max_length[255]',
                'label' => 'First Name',
                'errors' => [
                    'required' => 'First Name is required.',
                    'min_length' => 'First Name must be at least {value} characters long.',
                ]
            ],
            'last_name' => [
                'rules' =>'required|min_length[3]|max_length[255]',
                'label' => 'Last Name',
                'errors' => [
                    'required' => 'Last Name is required.',
                    'min_length' => 'Last Name must be at least {value} characters long.',
                ]
            ],
           'gender' => [
                'rules' =>'required',
                'label' => 'Member.member_gender',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'date_of_birth' => [
                'rules' =>'required',
                'label' => 'Date of Birth',
                'errors' => [
                   'required' => 'Date of Birth is required.',
                ]
            ],
            'phone' => [
                'rules' => 'required|regex_match[/^\+254\d{9}$/]',
                'label' => 'Phone',
                'errors' => [
                    'regex_match' => 'Phone number should be in the format +254XXXXXXXX',
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }
        
        $hashed_id = $this->request->getVar('id');
        $hashed_assembly_id = $this->request->getVar('assembly_id');

        // $encoded_member_id = hash_id($this->request->getVar('member_id'), 'encode');
        // $encoded_payment_id = hash_id($this->request->getVar('payment_id'), 'encode');

        $update_data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'gender' => $this->request->getPost('gender'),
            'member_number' => $this->request->getPost('member_number'),
            'designation_id' => $this->request->getPost('designation_id'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        // $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,dir: 'decode'), $this->tableName, $customFieldValues);

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
            $this->feature = 'member';
            $this->action = 'list';

            $records = $this->model
            ->select('members.id,members.first_name,gender,designations.name as designation_name,assemblies.name as assembly_name,members.last_name,members.assembly_id,members.member_number,members.designation_id,members.date_of_birth,members.email,members.phone')
            ->join('designations','designations.id=members.designation_id')
            ->join('assemblies','assemblies.id=members.assembly_id')
            ->orderBy("members.created_at desc")
            ->where('assembly_id', hash_id($hashed_assembly_id,'decode'))
            ->findAll();
            return view("member/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("member/view/".$hashed_id))->with('message', 'Member updated successfully!');
    }

    private function computeMemberNumber($assembly_id) {
        $memberNumber = '';

        $entityModel = new \App\Models\EntitiesModel();
        $assemblyEntity = $entityModel->select('entities.entity_number,assemblies.name')
        ->join('assemblies', 'assemblies.entity_id = entities.id')
        ->where('assemblies.id', $assembly_id)->first();

        // log_message('error', json_encode($assembly_id));

        $assemblyEntityNumber = $assemblyEntity['entity_number'];
        // $maxEntityNumber = $this->model->selectMax('member_number')->where('assembly_id', $entity_id)->first();

        $memberCount = $this->model->where('assembly_id',$assembly_id)->countAllResults();
        ++$memberCount;
        $memberCount = str_pad($memberCount,4,'0',STR_PAD_LEFT);

        // $parentMember = $this->model->where('id', $entity_id)->first();
        // $parentMemberNumber = $parentMember['member_number'];

        $memberNumber = "$assemblyEntityNumber/ME/$memberCount";

        // while ($this->model->where('member_number', $memberNumber)->countAllResults() > 0) {
            // ++$memberCount;
            // $memberNumber = "$parentMemberNumber/$memberCount";
        // }

        return $memberNumber;
    }
}
