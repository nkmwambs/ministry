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
    
    public function index($parent_id = 0): string
    {
        $members = [];

        if($parent_id > 0){
            $members = $this->model->select('members.id,first_name,last_name,assembly_id,member_number,designation_id,date_of_birth,email,phone')
            ->where('assembly_id',hash_id($parent_id,'decode'))
            ->join('assemblies','assemblies.id=members.assembly_id')
            ->orderBy('members.created_at desc')
            ->findAll();
        }else{
            $members = $this->model->select('members.id,first_name,last_name,assembly_id,member_number,designation_id,date_of_birth,email,phone')
            ->join('assemblies','assemblies.id=members.assembly_id')
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
            // $page_data['parent_id'] = ;
            return view('member/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }   

    function post(){
        $insertId = 0;

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
            'member_number' => [
                'rules' =>'required|min_length[4]|max_length[255]',
                'label' => 'Member Number',
                'errors' => [
                    'required' => 'Member Number is required.',
                    'min_length' => 'Member Number must be at least {value} characters long.',
                ]
            ],
            'date_of_birth' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[50]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $assembly_id = hash_id($this->request->getPost('assembly_id'),'decode');

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'assembly_id' => $assembly_id,
            'member_number' => $this->request->getPost('member_number'),
            'designation_id' => $this->request->getPost('designation_id'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'member';
            $this->action = 'list';
            $records = $this->model->orderBy("created_at desc")->where('assembly_id', $assembly_id)->findAll();
            $page_data = parent::page_data($records);
            $page_data['parent_id'] = hash_id($assembly_id,'encode');
            return view("member/list", $page_data);
        }

        return redirect()->to(site_url("members/view/".hash_id($insertId)));
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|max_length[255]',
            'last_name' => 'required|max_length[255]',
            'member_number' => 'required|min_length[4]',
            'designation_id' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[50]',
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
            'member_number' => $this->request->getPost('member_number'),
            'designation_id' => $this->request->getPost('designation_id'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), $update_data);

        if($this->request->isAJAX()){
            $this->feature = 'member';
            $this->action = 'list';

            $records = $this->model
            ->select('members.id,members.first_name,members.last_name,members.assembly_id,members.member_number,members.designation_id,members.date_of_birth,members.email,members.phone')
            ->orderBy("members.created_at desc")
            ->where('assembly_id', hash_id($hashed_assembly_id,'decode'))
            ->findAll();
            return view("member/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("member/view/".$hashed_id))->with('message', 'Member updated successfully!');
    }

    // private function computeNextHierarchicalLevel($denomination_id){
    //     $maxLevel = $this->model->selectMax('level')->where('denomination_id', $denomination_id)->first();
    //     return $maxLevel['level'] + 1;
    // }
}
