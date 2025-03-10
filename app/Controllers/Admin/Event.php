<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Event extends WebController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\EventsModel();
    }

    public function fetchEvents()
    {
        $request = \Config\Services::request();

        // Get parameters sent by Datatables
        $draw = intval($request->getPost('draw'));
        $start = intval($request->getPost('start'));
        $length = intval($request->getPost('length'));
        $searchValue = $request->getPost('search')['value'];

        // Get the total number of records
        $totalRecords = $this->model->countAll();

        // Apply search filter if provided
        if (!empty($searchValue)) {
            $this->model->like('name', $searchValue)
                ->orLike('code', $searchValue)
                ->orLike('location', $searchValue)
                ->orLike('description', $searchValue)
                ->orLike('registration_fees', $searchValue);
        }

        // Get the filtered total
        $totalFiltered = $this->model->countAllResults(false);

        // Limit the results and fetch the data
        $this->model->limit($length, $start);
        $data = $this->model->find();

        // Loop through the data to apply hash_id()
        foreach ($data as &$event) {
            $event['hash_id'] = hash_id($event['id']);  // Add hashed ID to each record
        }

        // Prepare response data for DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $data,  // Now includes 'hash_id' in each record
        ];

        // Return JSON response
        return $this->response->setJSON($response);
    }

    public function view($id): string {
        // Fetch the event details
        $data = $this->model->getOne(hash_id($id,'decode'));

        unset($data->id);
        unset($data->denomination_id);
        unset($data->meeting_id);
    
        // Fetch participants for the event
        // $participantModel = new \App\Models\ParticipantsModel();
        // $data->other_details = $participantModel->getParticipantsByEventId(hash_id($id, 'decode'));
        // Pass the data to the view
        $page_data = parent::page_data($data, $id);
        
        return view('index', compact('page_data'));
    }    

    public function update(){

        $hashed_id = $this->request->getPost("id");

        $update_data = [
            'name'=> $this->request->getPost('name'),
            'code'=> $this->request->getPost('code'),
            'meeting_id'=> $this->request->getPost('meeting_id'),
            'start_date'=> $this->request->getPost('start_date'),
            'end_date'=> $this->request->getPost('end_date'),
            'location'=> $this->request->getPost('location'),
            'description'=> $this->request->getPost('description'),
            'denomination_id'=> $this->request->getPost('denomination_id'),
            'registration_fees'=> $this->request->getPost('registration_fees'),
        ];

        if (!$this->validateData($update_data,'editEvent')) {
            return response()->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

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

        if ($this->request->isAJAX()) {
            $this->feature = 'event';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view($this->session->get('user_type').'/event/list', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type').'/events/view'.$hashed_id))->with('message', 'Event updated seccessfuly!');
    }

    function post() {
        $insertId = 0;

        $data = [
            'name' => $this->request->getPost('name'),
            'code'=> $this->request->getPost('code'),
            'meeting_id' => $this->request->getPost('meeting_id'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'location' => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'registration_fees' => $this->request->getPost('registration_fees'),
        ];

        if (!$this->validateData($data,'addEvent')) {
            $validationErrors = $this->validator->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $event = new \App\Entities\Event($data);

        $this->model->insert($event);
        $insertId = $this->model->getInsertID();

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