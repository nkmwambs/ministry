<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Revenue extends BaseController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\RevenuesModel();
    }

    public function post() {
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'label' => 'Name',
                'errors' => [
                    'required' => 'Revenue Name is required',
                    'min_length' => 'Revenue Name must be at least {value} characters long',
                    'max_length' => 'Revenue Name cannot exceed {value} characters long'
                ]
            ],
            'description' => [
                'rules' =>'max_length[255]',
                'label' => 'Description',
                'errors' => [
                    'required' => 'Description is required.',
                    'max_length' => 'Description cannot exceed {value} characters long'
                ]
            ]
        ]);

        if ($this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id')
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'revenue';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('revenue/list', parent::page_data($records));
        }

        return redirect()->to(site_url('settings/view/' . hash_id($insertId)));
    }

    public function update() {
        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' =>'required|min_length[5]|max_length[255]',
                'label' => 'Name',
                'errors' => [
                    'required' => 'Revenue Name is required',
                   'min_length' => 'Revenue Name must be at least {value} characters long',
                   'max_length' => 'Revenue Name cannot exceed {value} characters long'
                ]
            ],
            'description' => [
                'rules' =>'max_length[255]',
                'label' => 'Description',
                'errors' => [
                   'required' => 'Description is required.',
                   'max_length' => 'Description cannot exceed {value} characters long'
                ]
            ]
        ]);

        if ($this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'denomination_id' => $this->request->getPost('denomination_id'),
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

        if ($this->request->isAJAX()) {
            $this->feature = 'revenue';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('deparment/list', parent::page_data($records));
        }

        return redirect()->to(site_url("revenue/view".$hashed_id));
    }
}
