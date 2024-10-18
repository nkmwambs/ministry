<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Department extends BaseController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\DepartmentsModel();
    }

    public function fetchDepartments()
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
                ->orLike('description', $searchValue);
        }

        // Get the filtered total
        $totalFiltered = $this->model->countAllResults(false);

        // Limit the results and fetch the data
        $this->model->limit($length, $start);
        $data = $this->model->find();

        // Loop through the data to apply hash_id()
        foreach ($data as &$department) {
            $department['hash_id'] = hash_id($department['id']);  // Add hashed ID to each record
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


    public function post() {
        $insertId = 0;

        // log_message('error', json_encode($this->request->getPost()));
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'denomination_id' => [
                'rules' => 'required',
                'label' => 'Denomination Name',
                'errors' => [
                    'required' => 'Department Name is required'
                ]
            ],
            'name' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'label' => 'Name',
                'errors' => [
                    'required' => 'Department Name is required',
                    'min_length' => 'Department Name must be at least {value} characters long',
                    'max_length' => 'Department Name cannot exceed {value} characters long'
                ]
            ],
            'description' => [
                'rules' =>'max_length[255]',
                'label' => 'Description',
                'errors' => [
                    'required' => 'Department description is required.',
                    'max_length' => 'Description cannot exceed {value} characters long'
                ]
            ],
            'department_code' => [
                'rules' =>'max_length[50]',
                'label' => 'Department Code',
                'errors' => [
                    'required' => 'Department Code is required.',
                    'max_length' => 'Department Code cannot exceed {value} characters long'
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'department_code' => $this->request->getPost('department_code'),
        ];

        $this->model->insert((object)$data);
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
           
            $this->feature = 'department';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('department/after_save', parent::page_data($records));
        }

        return redirect()->to(site_url('settings/view/' . hash_id($insertId)));
    }

    public function update() {
        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'denomination_id' => [
                'rules' => 'required',
                'label' => 'Denomination Name',
                'errors' => [
                    'required' => 'Department Name is required'
                ]
            ],
            'name' => [
                'rules' =>'required|min_length[5]|max_length[255]',
                'label' => 'Name',
                'errors' => [
                    'required' => 'Department Name is required',
                   'min_length' => 'Department Name must be at least {value} characters long',
                   'max_length' => 'Department Name cannot exceed {value} characters long'
                ]
            ],
            'description' => [
                'rules' =>'max_length[255]',
                'label' => 'Description',
                'errors' => [
                   'required' => 'Department description is required.',
                   'max_length' => 'Description cannot exceed {value} characters long'
                ]
            ],
            'department_code' => [
                'rules' =>'max_length[50]',
                'label' => 'Department Code',
                'errors' => [
                    'required' => 'Department Code is required.',
                    'max_length' => 'Department Code cannot exceed {value} characters long'
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'department_code' => $this->request->getPost('department_code'),
        ];

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
            $this->feature = 'department';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('setting/list', parent::page_data($records));
        }

        return redirect()->to(site_url("department/view".$hashed_id));
    }
}
