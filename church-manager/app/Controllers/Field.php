<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Field extends BaseController
{
    protected $model = null;
    protected $customfieldLibrary = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\FieldsModel();
        $this->customfieldLibrary = new \App\Libraries\FieldLibrary();
    }

    public function add(): string {
        $page_data = $this->page_data();
        $page_data['parent_id'] = $this->parent_id;

        if(method_exists($this->library,'addExtraData')){
            // Note the addExtraData updates the $page_data by reference
            $this->library->addExtraData($page_data);
        }

        // Get all custom fields for the 'users' table
        $customFields = $this->customfieldLibrary->getCustomFieldsForTable('fields');
        $page_data['customFields'] = $customFields;

        return view("$this->feature/add", $page_data);
    }

    public function edit(): string {
        $numeric_id = hash_id($this->id,'decode');

        if(method_exists($this->model, 'getEditData')){
            $data = $this->model->getEditData($numeric_id);
        }else{
            $data = $this->model->getOne($numeric_id);
        }

        $page_data = $this->page_data($data);
        
        if(method_exists($this->library,'editExtraData')){
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }

        // Get all custom fields for the 'users' table
        $customFields = $this->customfieldLibrary->getCustomFieldsForTable('fields');
        $page_data['customFields'] = $customFields;

        return view("$this->feature/edit", $page_data);
    }

    public function post()
    {
        $insertId = 0;

        $fieldName = $this->request->getPost('name');
        $fieldType = $this->request->getPost('type');

        $data = [
            'denomination_id' => $this->request->getPost('denomination_id'),
            'name' => $fieldName,
            'type' => $fieldType,
            'options' => $this->request->getPost('options'),
            'feature_id' => $this->request->getPost('feature_id'),
            'field_order' => $this->request->getPost('field_order'),
            'visible' => $this->request->getPost('visible'),
            // 'created_at' => date('Y-m-d H:i:s')
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'field';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('field/list', parent::page_data($records));
        }

        // Dynamically add the new field to the database table
        // $db = \Config\Database::connect();
        // $db->query("ALTER TABLE users ADD {$fieldName} {$this->mapFieldType($fieldType)}");

        return redirect()->to(site_url('settings/view/'.hash_id($insertId)));
    }

    public function update() {
        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validate();

        $update_data = [
            'denomination_id' => $this->request->getPost('denomination_id'),
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'options' => $this->request->getPost('options'),
            'feature_id' => $this->request->getPost('feature_id'),
            'field_order' => $this->request->getPost('field_order'),
            'visible' => $this->request->getPost('visible'),
            // 'created_at' => date('Y-m-d H:i:s')
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

        if ($this->request->isAJAX()) {
            $this->feature = 'field';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('field/list', parent::page_data($records));
        }

        return redirect()->to(site_url("field/view".$hashed_id));
    }

    // private function mapFieldType($fieldType)
    // {
    //     switch ($fieldType) {
    //         case 'text':
    //             return 'VARCHAR(255)';
    //         case 'number':
    //             return 'INT';
    //         case 'date':
    //             return 'DATE';
    //         // Add more type mappings as needed
    //         default:
    //             return 'VARCHAR(255)';
    //     }
    // }
}
