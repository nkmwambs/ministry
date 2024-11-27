<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Role extends WebController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\RolesModel();
    }

    public function post() {
        $insertID = 0;
        
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
                'rules'=> 'required|min_length[5]|max_length[255]',
                'label' => 'Name',
                'errors' => [
                    'required' => 'Role Name is required',
                    'min_length' => 'Role Name must be at least {value} characters long',
                    'max_length' => 'Role Name cannot exceed {value} characters long',
                    // 'alpha_space' => 'Role field can only contain alphabetic characters and spaces.',
                ]
            ],
            
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'default_role' => $this->request->getPost('default_role'),
            'denomination_id' => $this->request->getPost('denomination_id') == 0 ? NULL : $this->request->getPost('denomination_id')
        ];

        $this->model->insert((object)$data);
        $insertID = $this->model->getInsertID();

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
                $customFieldLibrary->saveCustomFieldValues(hash_id($insertID,'decode'), $this->tableName, $customFieldValues);
            }
        }

        if ($this->request->isAJAX()) {
            $this->feature = 'role';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view($this->session->get('user_type').'/role/list', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type').'/settings/view' . hash_id($insertID)))->with('message', 'Role added successfully!');;
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
                'rules'=> 'required|min_length[5]|max_length[255]|alpha_space',
                'label' => 'Name',
                'errors' => [
                    'required' => 'Role Name is required',
                    'min_length' => 'Role Name must be at least {value} characters long',
                    'max_length' => 'Role Name cannot exceed {value} characters long',
                    'alpha_space' => 'Role field can only contain alphabetic characters and spaces.',
                ]
            ],
            'default_role' => [
                'rules' => 'required|max_length[255]|alpha_space',
                'label' => 'Default Role',
                'errors' => [
                    'required' => 'Default Role is required',
                    'max_length' => 'Default Role cannot exceed {value} characters long',
                    'alpha_space' => 'Default Role field can only contain alphabetic characters and spaces.'
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['error' => $validation->getErrors()]);
        }
        
        $update_data = [
            'name' => $this->request->getPost('name'),
            'default_role' => $this->request->getPost('default_role'),
            'denomination_id' => $this->request->getPost('denomination_id') == 0 ? NULL : $this->request->getPost('denomination_id')
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);
        // $this->model->refresh();

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
            $this->feature = 'role';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view($this->session->get('user_type').'/role/list', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type').'/settings/view' . hash_id($hashed_id, 'decode')));
    }

    function getDefaultRole($denomination_id){
        $denominationHasDefaultRole = true;

        if($denomination_id > 0){
            $countDefaultRoles = $this->model->where(['denomination_id' => $denomination_id, 'default_role' => 'yes'])->countAllResults();
            $denominationHasDefaultRole = $countDefaultRoles > 0 ? true : false;
        }
        
        return response()->setJSON(compact('denominationHasDefaultRole'));
    }
}
