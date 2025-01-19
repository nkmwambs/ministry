<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Field extends WebController
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
        $customFields = $this->customfieldLibrary->getCustomFieldsForTable('customFields');
        $page_data['customFields'] = $customFields;

        return view($this->session->get('user_type')."/$this->feature/add", $page_data);
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
        $customFields = $this->customfieldLibrary->getCustomFieldsForTable('customFields');
        $page_data['customFields'] = $customFields;

        return view($this->session->get('user_type')."/$this->feature/edit", $page_data);
    }

    public function post()
    {
        $insertId = 0;
        $feature_id = $this->request->getPost('feature_id');
        $fieldType = $this->request->getPost('type');
        
        $featureLibrary = new \App\Libraries\FeatureLibrary();
        $table_name = plural($featureLibrary->getFeatureTableNameById($feature_id));
        

        $data = [
            'denomination_id' => $this->request->getPost('denomination_id'),
            'field_name' => $this->request->getPost('field_name'),
            'field_code' => $this->request->getPost('field_code'),
            'helptip' => $this->request->getPost('helptip'),
            'type' => $fieldType,
            'options' => $fieldType == "dropdown" || $fieldType == "boolean" ? $this->request->getPost('options'): NULL,
            'code_builder' => $table_name == 'reports' ? $this->request->getPost('code_builder'): NULL,
            'feature_id' => $this->request->getPost('feature_id'),
            'table_name' => $table_name,
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'customfield';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view($this->session->get('user_type').'/field/list', parent::page_data($records));
        }

        return redirect()->to(site_url('settings/view/'.hash_id($insertId)));
    }

    public function update() {
        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validate();

        $feature_name = $this->request->getPost('feature_name');
        $fieldType = $this->request->getPost('type');
        
        $table_name = plural($feature_name);

        $update_data = [
            'field_name' => $this->request->getPost('field_name'),
            'helptip' => $this->request->getPost('helptip'),
            'type' => $fieldType,
            'options' => $fieldType == "dropdown" || $fieldType == "boolean" ? $this->request->getPost('options'): NULL,
            'code_builder' => $table_name == 'reports' ? $this->request->getPost('code_builder'): NULL,
            'visible' => $this->request->getPost('visible'),
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

            return view($this->session->get('user_type').'/field/list', parent::page_data($records));
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
