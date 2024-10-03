<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Field extends BaseController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\FieldsModel();
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
