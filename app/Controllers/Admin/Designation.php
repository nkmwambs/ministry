<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Designation extends WebController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this ->model = new \App\Models\DesignationsModel();

    }

    // public function fetchDesignations()
    // {
    //     $request = \Config\Services::request();

    //     // Get parameters sent by Datatables
    //     $draw = intval($request->getPost('draw'));
    //     $start = intval($request->getPost('start'));
    //     $length = intval($request->getPost('length'));
    //     $searchValue = $request->getPost('search')['value'];

    //     // Get the total number of records
    //     $totalRecords = $this->model->countAll();

    //     // Apply search filter if provided
    //     if (!empty($searchValue)) {
    //         $this->model->like('name', $searchValue)
    //             ->orLike('denomination_id', $searchValue)
    //             ->orLike('is_minister_title_designation', $searchValue)
    //             ->orLike('is_hierarchy_leader_designation', $searchValue)
    //             ->orLike('is_department_leader_designation', $searchValue);
    //     }

    //     // Get the filtered total
    //     $totalFiltered = $this->model->countAllResults(false);

    //     // Limit the results and fetch the data
    //     $this->model->limit($length, $start);
    //     $data = $this->model->find();

    //     // Loop through the data to apply hash_id()
    //     foreach ($data as &$designation) {
    //         $designation['hash_id'] = hash_id($designation['id']);  // Add hashed ID to each record
    //     }

    //     // Prepare response data for DataTables
    //     $response = [
    //         "draw" => $draw,
    //         "recordsTotal" => $totalRecords,
    //         "recordsFiltered" => $totalFiltered,
    //         "data" => $data,  // Now includes 'hash_id' in each record
    //     ];

    //     // Return JSON response
    //     return $this->response->setJSON($response);
    // }

    public function post() {
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'label' => 'Designation Name',
                'errors' => [
                'required' => 'Designation Name is required.',
                'min_length' => 'Designation Name must be at least {value} characters long.',
                'max_length' => 'Designation Name cannot exceed {value} characters.'
                ]
            ],
            'denomination_id' => [
                'rules' => 'required',
                'label' => 'Denomination Name',
                'errors' => [
                'required' => 'Denomination Name is required.'
                ]
            ],
            'is_minister_title_designation' => [
                'rules' => 'required',
                'label' => 'Check Minister',
                'errors' => [
                'required' => 'Check Minister is required.'
                ]
            ],
            'is_hierarchy_leader_designation' => [
                'rules' => 'required',
                'label' => 'Check Hierarchy Leader Designation',
                'errors' => [
                'required' => 'Check Hierarchy Leader Designation is required.',
                ]
            ],
            'is_department_leader_designation' => [
                'rules' => 'required_with[department_id]',
                'label' => 'Check Department Leader Designation',
                'errors' => [
                'required' => 'Check Department Leader Designation is required.',
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'is_hierarchy_leader_designation' => $this->request->getPost('is_hierarchy_leader_designation'),
            'is_department_leader_designation' => $this->request->getPost('is_department_leader_designation'),
            'is_minister_title_designation' => $this->request->getPost('is_minister_title_designation'),
            'department_id' => $this->request->getPost('is_department_leader_designation') == 'yes' ? $this->request->getPost('department_id'): NULL,
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
            $this->feature = 'designation';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view($this->session->get('user_type').'/designation/list', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type').'/settings/view/' . hash_id($insertId)));
    }

    public function update() {
        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'label' => 'Designation Name',
                'errors' => [
                'required' => 'Designation Name is required.',
                'min_length' => 'Designation Name must be at least {value} characters long.',
                'max_length' => 'Designation Name cannot exceed {value} characters.'
                ]
            ],
            'denomination_id' => [
                'rules' => 'required',
                'label' => 'Denomination Name',
                'errors' => [
                'required' => 'Denomination Name is required.'
                ]
            ],
            'is_minister_title_designation' => [
                'rules' => 'required',
                'label' => 'Check Minister',
                'errors' => [
                'required' => 'Check Minister is required.'
                ]
            ],
            'is_hierarchy_leader_designation' => [
                'rules' => 'required',
                'label' => 'Check Hierarchy Leader Designation',
                'errors' => [
                'required' => 'Check Hierarchy Leader Designation is required.',
                ]
            ],
            'is_department_leader_designation' => [
                'rules' => 'required',
                'label' => 'Check Department Leader Designation',
                'errors' => [
                'required' => 'Check Department Leader Designation is required.',
                ]
            ],
        ]);


        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'is_hierarchy_leader_designation' => $this->request->getPost('is_hierarchy_leader_designation'),
            'is_department_leader_designation' => $this->request->getPost('is_department_leader_designation'),
            'is_minister_title_designation' => $this->request->getPost('is_minister_title_designation'),
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
            $this->feature = 'designation';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view($this->session->get('user_type').'/designation/list', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type')."/designation/view".$hashed_id));
    }
}

