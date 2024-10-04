<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class Designation extends BaseController
{
    protected $model = null;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $this ->model = new \App\Models\DesignationsModel();

    }

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

        $data = [
            'name' => $this->request->getPost('name'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'is_hierarchy_leader_designation' => $this->request->getPost('is_hierarchy_leader_designation'),
            'is_department_leader_designation' => $this->request->getPost('is_department_leader_designation'),
            'is_minister_title_designation' => $this->request->getPost('is_minister_title_designation'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'designation';
            $this->action = 'list';
            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('designation/list', parent::page_data($records));
        }

        return redirect()->to(site_url('settings/view/' . hash_id($insertId)));
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

        if ($this->request->isAJAX()) {
            $this->feature = 'designation';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('designation/list', parent::page_data($records));
        }

        return redirect()->to(site_url("designation/view".$hashed_id));
    }
}

