<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Member extends BaseController
{
    protected $model = null;
    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\MembersModel();
    }

    public function index($limit = 10): string
{
    // Fetch top members based on level or another criterion
    $members = $this->model->select('members.id,first_name,last_name, member_number, designation_id,date_of_birth, email, phone, is_active, assembly_id')
        ->join('assemblies', 'assemblies.id = members.assembly_id')
        ->orderBy('members.created_at desc')
        ->limit($limit) 
        ->findAll();

    $page_data['result'] = $members ?: [];
    $page_data['feature'] = 'view';
    $page_data['action'] = 'view';

    if ($this->request->isAJAX()) {
        return view('member/view', $page_data);
    } else {
        $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        return view('index', $page_data);
    }
}

    // public function index($id = 0): string
    // {
    //     $members = [];

    //     if($id > 0){
    //         $members = $this->model->select('members.id,first_name,last_name,member_number,designation_id,date_of_birth,email,phone,is_active')
    //         ->where('assembly_id',hash_id($id,'decode'))
    //         ->join('assemblies','assemblies.id=members.assembly_id')
    //         ->orderBy('members.created_at desc')
    //         ->findAll();
    //     }else{
    //         $members = $this->model->select('members.id,first_name,last_name,member_number,designation_id,date_of_birth,email,phone,is_active')
    //         ->join('assemblies','assemblies.id=members.assembly_id')
    //         ->orderBy('members.created_at desc')
    //         ->findAll();
    //     }
        
    //     if(!$members){
    //         $page_data['result'] = [];
    //     }else{
    //         $page_data['result'] = $members;
    //     }

    //     $page_data['result'] = $members;
    //     $page_data['feature'] = 'member';
    //     $page_data['action'] = 'list';
        
    //     if ($this->request->isAJAX()) {
    //         $page_data['id'] = $id;
    //         return view('member/list', $page_data);
    //     }else{
    //         $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
    //     }

    //     return view('index', $page_data);
    // }

    public function add($id = 0): string {
        $page_data['feature'] = 'member';
        $page_data['action'] = 'add';
        return view('index', $page_data);
    }

    function post(){
        $insertId = 0;


        $assembly_id = hash_id($this->request->getPost('assembly_id'),'decode');

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'member_number' =>  $this->request->getPost('member_number'),
            'designation_id' =>  $this->request->getPost('designation_id'),
            'date_of_birth' =>  $this->request->getPost('date_of_birth'),
            'email' =>  $this->request->getPost('email'),
            'phone' =>  $this->request->getPost('phone'),
            'is_active' =>  $this->request->getPost('is_active'),
            'assembly_id' => $assembly_id,
                ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'member';
            $this->action = 'list';
            $records = $this->model->orderBy("created_at desc")->where('assembly_id', $assembly_id)->findAll();
            $page_data = parent::page_data($records);
            $page_data['id'] = hash_id($assembly_id,'encode');
            // log_message('error', json_encode($page_data));
            return view("member/list", $page_data);
        }

        return redirect()->to(site_url("assemblies/view/".hash_id($insertId)));
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');
        $assembly_id = hash_id($this->request->getPost('assembly_id'), 'decode');

        $update_data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'member_number' =>  $this->request->getPost('member_number'),
            'designation_id' =>  $this->request->getPost('designation_id'),
            'date_of_birth' =>  $this->request->getPost('date_of_birth'),
            'email' =>  $this->request->getPost('email'),
            'phone' =>  $this->request->getPost('phone'),
            'is_active' =>  $this->request->getPost('is_active'),
            'assembly_id' => $assembly_id
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), $update_data);

        if($this->request->isAJAX()){
            $this->feature = 'member';
            $this->action = 'list';

            $records = $this->model
            ->select('members.id,members.name,member_number,designation_id')
            ->orderBy("members.created_at desc")
            ->where('assembly_id', hash_id($this->request->getVar('id'),'decode'))
            ->findAll();
            return view("member/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("member/view/".$hashed_id))->with('message', 'member updated successfully!');
    }

}