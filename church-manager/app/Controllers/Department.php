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

    public function index($id = 0): string {
        $departments = [];

        if ($id > 0) {
            $departments = $this->model->select('departments.id,name,denomination_id')
            ->where('denomination_id', $id)
            ->join('denominations as parent', 'parent.id = departments.denomination_id', 'LEFT')
            ->orderBy('deparments.created_at','desc')
            ->findAll();
        } else {
            $departments = $this->model->select('departments.id,name,denomination_id')
            ->join('denominations as parent', 'parent.id = departments.denomination_id')
            ->orderBy('deparments.created_at','desc')
            ->findAll();
        }

        if (!$departments) {
            $page_data['result'] = [];
        } else {
            $page_data['result'] = $departments;
        }

        $page_data['result'] = $departments;
        $page_data['feature'] = 'department';
        $page_data['action'] = 'list';

        if ($this->request->isAJAX()) {
            return view('department/list');
        } else {
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }

    public function post() {
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
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
            $this->feature = 'department';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('department/list', parent::page_data($records));
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
            $this->feature = 'department';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('deparment/list', parent::page_data($records));
        }

        return redirect()->to(site_url("department/view".$hashed_id));
    }
}