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

    
    

    // public function index($id = 0): string {
    //     $designations = [];

    //     if ($id > 0) {
    //         $designations = $this->model->select('designation.id,name,denomination_id',)
    //         ->where('denomination_id', $id)
    //         ->join('denominations as parent', 'parent.id = designation.denomination_id', 'LEFT')
    //         ->orderBy('designation.created_at','desc')
    //         ->findAll();
    //     } else {
    //         $departments = $this->model->select('designation.id,name,denomination_id')
    //         ->join('denominations as parent', 'parent.id = designation.denomination_id')
    //         ->orderBy('designations.created_at','desc')
    //         ->findAll();
    //     }

    //     if (!$designations) {
    //         $page_data['result'] = [];
    //     } else {
    //         $page_data['result'] = $designations;
    //     }

    //     $page_data['result'] = $designations;
    //     $page_data['feature'] = 'designations';
    //     $page_data['action'] = 'list';

    //     if ($this->request->isAJAX()) {
    //         return view('department/list');
    //     } else {
    //         $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
    //     }

    //     return view('index', $page_data);
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
                'rules' => 'required|max_length[255]',
                'label' => 'Denomination Name',
                'errors' => [
                'required' => 'Denomination Name is required.',
                'min_length' => 'Denomination Name must be at least {value} characters long.',
                ]
            ],
            'hierarchy_id' => [
                'rules' => 'required|max_length[255]',
                'label' => 'Hierarchy ID',
                'errors' => [
                'required' => 'Hierarchy ID is required.',
                'min_length' => 'Hierarchy ID must be at least {value} characters long.',
                ]
            ],
            'department_id' => [
                'rules' => 'required|max_length[255]',
                'label' => 'Department Name',
                'errors' => [
                'required' => 'Department Name is required.',
                'min_length' => 'Department Name must be at least {value} characters long.',
                ]
            ],
            'minister_title_designation' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'label' => 'Designation Name',
                'errors' => [
                'required' => 'Designation Name is required.',
                'min_length' => 'Designation Name must be at least {value} characters long.',
                'max_length' => 'Minister Designation Title Name cannot exceed {value} characters.'
                ]
            ],
        ]);

        if ($this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'hierarchy_id' => $this->request->getPost('hierarchy_id	'),
            'department_id' => $this->request->getPost('department_id	'),
            'minister_title_designation' => $this->request->getPost('minister_title_designation	'),

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
                'rules' => 'required|max_length[255]',
                'label' => 'Denomination ID',
                'errors' => [
                'required' => 'Denomination ID is required.',
                'min_length' => 'Denomination ID must be at least {value} characters long.',
                ]
            ],
            'hierarchy_id' => [
                'rules' => 'required|max_length[255]',
                'label' => 'Hierarchy ID',
                'errors' => [
                'required' => 'Hierarchy ID is required.',
                'min_length' => 'Hierarchy ID must be at least {value} characters long.',
                ]
            ],
            'department_id' => [
                'rules' => 'required|max_length[255]',
                'label' => 'Department ID',
                'errors' => [
                'required' => 'Department ID is required.',
                'min_length' => 'Department ID must be at least {value} characters long.',
                ]
            ],
            'minister_title_designation' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'label' => 'Designation Name',
                'errors' => [
                'required' => 'Designation Name is required.',
                'min_length' => 'Designation Name must be at least {value} characters long.',
                'max_length' => 'Minister Designation Title Name cannot exceed {value} characters.'
                ]
            ],
        ]);

        if ($this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'denomination_id' => $this->request->getPost('denomination_id'),
            'hierarchy_id' => $this->request->getPost('hierarchy_id'),
            'department_id' => $this->request->getPost('department_id'),
            'minister_title_designation' => $this->request->getPost('minister_title_designation'),


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

