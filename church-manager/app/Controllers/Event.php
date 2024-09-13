<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Event extends BaseController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\EventsModel();
    }

    public function view($id): string {
        // Fetch the event details
        $data = $this->model->getOne(hash_id($id,'decode'));
        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }
    
        // Fetch participants for the event
        $participantModel = new \App\Models\ParticipantsModel();
        $data['other_details'] = $participantModel->getParticipantsByEventId(hash_id($id, 'decode'));
    
        // Pass the data to the view
        $page_data = parent::page_data($data, $id);
        
        return view('index', $page_data);
    }    

    public function update(){

        $hashed_id = $this->request->getPost("id");

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'meeting_id' => 'required',
            'location' => 'required|max_length[255]',
            'description' => 'required|max_length[255]',
            'denomination_id' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name'=> $this->request->getPost('name'),
            'meeting_id'=> $this->request->getPost('meeting_id'),
            'start_date'=> $this->request->getPost('start_date'),
            'end_date'=> $this->request->getPost('end_date'),
            'location'=> $this->request->getPost('location'),
            'description'=> $this->request->getPost('description'),
            'denomination_id'=> $this->request->getPost('denomination_id'),
            'registration_fees'=> $this->request->getPost('registration_fees'),
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

        if ($this->request->isAJAX()) {
            $this->feature = 'event';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('event/list', parent::page_data($records));
        }

        return redirect()->to(site_url('events/view'.$hashed_id))->with('message', 'Event updated seccessfuly!');
    }

    function post() {
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'meeting_id' => 'required',
            'location' => 'required|max_length[255]',
            'description' => 'required|max_length[255]',
            'denomination_id' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'meeting_id' => $this->request->getPost('meeting_id'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'location' => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'registration_fees' => $this->request->getPost('registration_fees'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'event';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            $page_data = parent::page_data($records);

            return view('event/list', $page_data);
        }

        return redirect()->to(site_url('events/view'.hash_id($insertId)))->with('message', 'Event added seccessfuly!');;
    }

}