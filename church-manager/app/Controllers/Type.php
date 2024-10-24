<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Type extends WebController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\TypesModel();
    }

    public function post() {
        $insertId = 0;

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
                    'required' => 'Meeting Name is required',
                    'min_length' => 'Meeting Name must be at least {value} characters long',
                    'max_length' => 'Meeting Name cannot exceed {value} characters long'
                ]
            ],
            'type_code' => [
                'rules' =>'max_length[50]',
                'label' => 'Type Code',
                'errors' => [
                    'required' => 'Type Code is required.',
                    'max_length' => 'Type Code cannot exceed {value} characters long'
                ]
            ]
        ]);

        // log_message('error', json_encode($this->request->getPost('layout')));

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'type_code' => $this->request->getPost('type_code'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'report_layout' => json_encode($this->request->getPost('layout')),
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
            $this->feature = 'type';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('type/list', parent::page_data($records));
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
                ],
            ],
            'name' => [
                'rules' =>'required|min_length[5]|max_length[255]',
                'label' => 'Name',
                'errors' => [
                    'required' => 'Meeting Name is required',
                   'min_length' => 'Meeting Name must be at least {value} characters long',
                   'max_length' => 'Meeting Name cannot exceed {value} characters long'
                ],
            ],
            'type_code' => [
                'rules' =>'max_length[50]',
                'label' => 'Type Code',
                'errors' => [
                    'required' => 'Type Code is required.',
                    'max_length' => 'Type Code cannot exceed {value} characters long'
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
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
            $this->feature = 'type';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('type/list', parent::page_data($records));
        }

        return redirect()->to(site_url("type/view".$hashed_id));
    }
}
