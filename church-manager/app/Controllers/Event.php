<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Event extends BaseController
{
    private $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\EventsModel();
    }

    public function index(): string
    {
        $events = $this->model->select('name,gatheringtype_id,start_date,end_date,location,description,denomination_id,registration_fees')
        ->findAll();

        $page_data['result'] = $events;
        $page_data['feature'] = 'event';
        $page_data['action'] = 'list';

        return view('index', $page_data);
    }

    public function add():string
    {
        $page_data['feature'] = 'event';
        $page_data['action'] = 'add';

        return view('add', $page_data);
    }

    public function view($id): string {
        $event = $this->model->select('name,gatheringtype_id,start_date,end_date,location,description,denomination_id,registration_fees')
        ->where('id', hash_id($id, 'decode'))
        ->first();

        $page_data['result'] = $event;
        $page_data['feature'] = 'event';
        $page_data['action'] = 'view';

        return view('index', $page_data);
    }

    public function post() {
        $data = [
            'name' => $this->request->getPost('name'),
            'gatheringtype_id' => $this->request->getPost('gatheringtype_id'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'location' => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'registration_fees' => $this->request->getPost('registration_fees'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        return redirect()->to(site_url('events/view/'.$insertId));
    }

    public function edit($id) {
        $data = [
            'name' => $this->request->getPost('name'),
            'gatheringtype_id' => $this->request->getPost('gatheringtype_id'),
            'start_date' => $this->request->getPost('start_date'),
            'location'=> $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'registration_fees' => $this->request->getPost('registration_fees'),
        ];

        $this->model->update(hash_id($id, 'decode'), $data);

        return redirect()->to(site_url('events/view/'.$id));
    }

    public function delete($id) {
        $this->model->delete(hash_id($id, 'decode'));
        return redirect()->to(site_url('events'));
    }
}
