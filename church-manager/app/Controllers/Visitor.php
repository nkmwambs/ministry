<?php

namespace App\Controllers;

use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Visitor extends WebController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\VisitorsModel();
    }
    
    public function index($parent_id = 0): string
    {
        $visitors = [];

        if($parent_id > 0){
            $visitors = $this->model->select('visitors.id,first_name,last_name,phone,email,gender,date_of_birth,event_id,payment_id,payment_code,registration_amount,status')
            ->where('event_id',hash_id($parent_id,'decode'))
            ->join('events','events.id=visitors.event_id')
            ->orderBy('visitors.created_at desc')
            ->findAll();
        }else{
            $visitors = $this->model->select('visitors.id,first_name,last_name,phone,email,gender,date_of_birth,event_id,payment_id,payment_code,registration_amount,status')
            ->join('events','events.id=visitors.event_id')
            ->orderBy('visitors.created_at desc')
            ->findAll();
        }

        // log_message('error', json_encode($visitors));
       
        if(!$visitors){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $visitors;
        }

        $page_data['result'] = $visitors;
        $page_data['feature'] = 'visitor';
        $page_data['action'] = 'list';
        
        if ($this->request->isAJAX()) {
            $page_data['parent_id'] = $parent_id;
            return view('visitor/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|max_length(255)',
            'last_name' => 'required|max_length(255)',
            'phone' => 'required',
            'email'=> 'required|valid_email',
            'gender' => 'required|min_length(4)',
            'date_of_birth' => 'required',
            'payment_id' => 'required|min_length(4)',
            'payment_code' => 'required',
            'registration_amount' => 'required',
            'status'=> 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $event_id = hash_id($this->request->getPost('event_id'),'decode');
        // $member_id = hash_id($this->request->getPost('member_id'), 'decode');
        // $payment_id = hash_id($this->request->getPost('payment_id'), 'decode');

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'email'=> $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'event_id' => $event_id,
            'payment_id' => $this->request->getPost('payment_id'),
            'payment_code' => $this->request->getPost('payment_code'),
            'registration_amount' => $this->request->getPost('registration_amount'),
            'status'=> $this->request->getPost('status'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'visitor';
            $this->action = 'list';
            $records = $this->model->orderBy("created_at desc")->where('event_id', $event_id)->findAll();
            $page_data = parent::page_data($records);
            $page_data['id'] = hash_id($event_id,'encode');
            // log_message('error', json_encode($page_data));
            return view("visitor/list", $page_data);
        }

        return redirect()->to(site_url("visitors/view/".hash_id($insertId)));
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|max_length(255)',
            'last_name' => 'required|max_length(255)',
            'phone' => 'required',
            'email'=> 'required|valid_email',
            'gender' => 'required|min_length(4)',
            'date_of_birth' => 'required',
            'payment_id' => 'required|min_length(4)',
            'payment_code' => 'required',
            'registration_amount' => 'required',
            'status'=> 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }
        
        $hashed_id = $this->request->getVar('id');
        $hashed_event_id = $this->request->getVar('event_id');

        // $encoded_member_id = hash_id($this->request->getVar('member_id'), 'encode');
        // $encoded_payment_id = hash_id($this->request->getVar('payment_id'), 'encode');

        $update_data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'email'=> $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'payment_id' => $this->request->getPost('payment_id'),
            'payment_code' => $this->request->getPost('payment_code'),
            'registration_amount' => $this->request->getPost('registration_amount'),
            'status'=> $this->request->getPost('status'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        if($this->request->isAJAX()){
            $this->feature = 'visitor';
            $this->action = 'list';

            $records = $this->model
            ->select('visitors.id,visitors.first_name,visitors.last_name,visitors.phone,visitors.email,visitors.gender,visitors.date_of_birth,visitors.event_id,payment_id,visitors.payment_code,visitors.registration_amount,visitors.status')
            ->orderBy("visitors.created_at desc")
            ->where('event_id', hash_id($hashed_event_id,'decode'))
            ->findAll();
            return view("visitor/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("visitor/view/".$hashed_id))->with('message', 'Visitor updated successfully!');
    }

    // private function computeNextHierarchicalLevel($denomination_id){
    //     $maxLevel = $this->model->selectMax('level')->where('denomination_id', $denomination_id)->first();
    //     return $maxLevel['level'] + 1;
    // }
}
