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
            $participants = $this->model->select('participants.id,member_id,event_id,payment_id,payment_code,registration_amount,status')
            ->where('event_id',hash_id($parent_id,'decode'))
            ->join('events','events.id=participants.event_id')
            ->orderBy('participants.created_at desc')
            ->findAll();
        }else{
            $participants = $this->model->select('participants.id,member_id,event_id,payment_id,payment_code,registration_amount,status')
            ->join('events','events.id=participants.event_id')
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
            'registration_amount' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $data = [
            'member_id' => $this->request->getPost('member_id'),
            'event_id' => $this->request->getPost('event_id'),
            'payment_id' => $this->request->getPost('payment_id'),
            'payment_code' => $this->request->getPost('payment_code'),
            'registration_amount' => $this->request->getPost('registration_amount'),
            'status' => $this->request->getPost('status'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'participant';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }
            // $records = $this->model->orderBy("created_at desc")->where('event_id', $event_id)->findAll();
            // $page_data = parent::page_data($records, $hashed_event_id);
            // $page_data['id'] = hash_id($event_id,'encode');
            return view("participant/list", parent::page_data($records));
        }

        return redirect()->to(site_url("participants/view/".hash_id($insertId)));
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
