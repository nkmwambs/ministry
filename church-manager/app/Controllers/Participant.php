<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Participant extends BaseController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\ParticipantsModel();
    }
    
    public function index($parent_id = 0): string
    {
        $participants = [];

        if($parent_id > 0){
            $participants = $this->model->select('participants.id,member_id, CONCAT(members.first_name," ", members.last_name) as member_name,event_id,events.name as event_name,payment_id,payment_code,registration_amount,status')
            ->where('event_id',hash_id($parent_id,'decode'))
            ->join('events','events.id=participants.event_id')
            ->join('members','members.id=participants.member_id')
            ->orderBy('participants.created_at desc')
            ->findAll();
        }else{
            $participants = $this->model->select('participants.id,member_id,CONCAT(members.first_name," ", members.last_name) as member_name,event_id,events.name as event_name,payment_id,payment_code,registration_amount,status')
            ->join('events','events.id=participants.event_id')
            ->join('members','members.id=participants.member_id')
            ->orderBy('participants.created_at desc')
            ->findAll();
        }
       
        if(!$participants){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $participants;
        }

        $page_data['result'] = $participants;
        $page_data['feature'] = 'participant';
        $page_data['action'] = 'list';
        
        if ($this->request->isAJAX()) {
            $page_data['parent_id'] = $parent_id;
            return view('participant/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }

    // public function add($parent_id = 0): string {
    //     $page_data['feature'] = 'participant';
    //     $page_data['action'] = 'add';
    //     return view('index', $page_data);
    // }    

    public function post()
    {
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'member_id' => [
                'rules' =>'required',
                'label' => 'Members',
                'errors' => [
                   'required' => 'Members are required.',
                ]
            ],
            'due_registration_amount' => [
                'rules' =>'required',
                'label' => 'Registration Due Amount',
                'errors' => [
                   'required' => 'Registration Due Amount is required. Please choose a member',
                ]
                ],
                "paying_phone_number" => [
                    'rules' =>'required|regex_match[/^254\d{9}$/]',
                    'label' => 'Paying Phone Number',
                    'errors' => [
                       'required' => 'Paying Phone Number is required.',
                       'regex_match' => 'Phone number should be in the format +254XXXXXXXX',
                    ]
                ]
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        // $numeric_event_id = hash_id($this->request->getPost('event_id'), 'decode');
        $hashed_event_id = $this->request->getPost('event_id');
        $numeric_event_id = hash_id($hashed_event_id, 'decode');
        
        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'event_id' => $numeric_event_id,
            'due_registration_amount' => $this->request->getPost('due_registration_amount'),
            'paying_phone_number' => $this->request->getPost('paying_phone_number'),
        ];

        // Call MPesa API to send a payment request to the customer phone number
        $mpesa_response = $this->notifyCustomerForMpesaPayment($data['paying_phone_number'], $data['due_registration_amount']);
        
        if($mpesa_response['ResponseCode'] == 0){
            $participantLibrary = new \App\Libraries\ParticipantLibrary();
            $participantLibrary->insertParticipants($data);
            // log_message('error', json_encode($data));

            $this->feature = 'participant';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            $this->parent_id = $this->request->getPost('event_id');
            $this->id = hash_id($insertId, 'encode');
            return view("participant/list", parent::page_data($records));
        }
        
        // if($this->request->isAJAX()){
        //     $this->feature = 'participant';
        //     $this->action = 'list';
        //     $records = [];

        //     if (method_exists($this->model, 'getAll')) {
        //         $records = $this->model->getAll();
        //     } else {
        //         $records = $this->model->findAll();
        //     }

        //     $this->parent_id = $this->request->getPost('event_id');
        //     $this->id = hash_id($insertId, 'encode');
        //     return view("participant/list", parent::page_data($records));
        // }

        return redirect()->to(site_url("participants/view/".hash_id($insertId)));
    }

    private function notifyCustomerForMpesaPayment($phone_number, $amount){
       
        sleep(3);

        $denomination_code = "COGOP";
        $payment_purpose = "Payment of Women Conference";

        $mpesaLibrary = new \App\Libraries\MpesaLibrary();
        // $res = $mpesaLibrary->express($denomination_code,$payment_purpose, $phone_number, $amount);

        // Listen to the STK response for actual payment

        $response = ['ResponseCode' => 0]; //json_decode($res,true);
        // $response = json_decode($res,true);
        
        return $response;
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'registration_amount' => 'required',
            'status' => 'required',
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
            'member_id' => $this->request->getPost('member_id'),
            'payment_id' => $this->request->getPost('payment_id'),
            'payment_code' => $this->request->getPost('payment_code'),
            'registration_amount' => $this->request->getPost('registration_amount'),
            'status' => $this->request->getPost('status'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        if($this->request->isAJAX()){
            $this->feature = 'participant';
            $this->action = 'list';

            $records = $this->model
            ->select('participants.id,participants.member_id,participants.event_id,participants.payment_id,participants.payment_code,registration_amount, status')
            ->orderBy("participants.created_at desc")
            ->where('event_id', hash_id($hashed_event_id,'decode'))
            ->findAll();

            $page_data = parent::page_data($records, $hashed_event_id);
            $page_data['parent_id'] = $hashed_event_id;

            return view("participant/list", $page_data);
        }
        
        return redirect()->to(site_url("participants/view/".$hashed_id))->with('message', 'Participant updated successfully!');
    }

    public function getParticipantsByEventId($hashed_event_id){
        $event_id = hash_id($hashed_event_id,'decode');

        $participants = $this->model->select('id, member_id')->where(['event_id' => $event_id])->findAll();
        $participants = array_map(function($elem){
            $elem['id'] = hash_id($elem['id'], 'encode');

            return $elem;
        }, $participants);

        return response()->setJSON($participants);
    }
}
