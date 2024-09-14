<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Task extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\TasksModel();
    }

    public function post() {
        $insertID = 0;
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'user_id' => [
                'rules' => 'required',
                'label' => 'User Name',
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
            // 'default_role' => $this->request->getPost('default_role'),
            // 'denomination_id' => $this->request->getPost('denomination_id') == 0 ? NULL : $this->request->getPost('denomination_id')
        ];

        $this->model->insert((object)$data);
        $this->model->getInsertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'task';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('task/list', parent::page_data($records));
        }

        return redirect()->to(site_url('users/view' . hash_id($insertID)))->with('message', 'Role added successfully!');;
    }

    public function update() {
        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'user_id' => [
                'rules' => 'required',
                'label' => 'User Name',
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
            'status' => [
                'rules' => 'required|max_length[255]|alpha_space',
                'label' => 'Status',
                'errors' => [
                    'required' => 'Status is required',
                    'max_length' => 'Status cannot exceed {value} characters long',
                    'alpha_space' => 'Status field can only contain alphabetic characters and spaces.'
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['error' => $validation->getErrors()]);
        }
        
        $update_data = [
            'name' => $this->request->getPost('name'),
            'status' => $this->request->getPost('status'),
            // 'denomination_id' => $this->request->getPost('denomination_id') == 0 ? NULL : $this->request->getPost('denomination_id')
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);
        // $this->model->refresh();
        if ($this->request->isAJAX()) {
            $this->feature = 'task';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('task/list', parent::page_data($records));
        }

        return redirect()->to(site_url('users/view' . hash_id($hashed_id, 'decode')));
    }

    function updateTaskStatus(){
        $tasksModel = $this->model;
        $user_id = $this->request->getPost('user_id');
        // $feature_id = $this->request->getPost('feature_id');
        $task_status = $this->request->getPost('status');

        $countAssignedUserTasks = $tasksModel->where(['user_id' => $user_id])->countAllResults();
        log_message('error', json_encode($countAssignedUserTasks));
        if($countAssignedUserTasks == 0){
            $this->model->insert($this->request->getPost());
        }else{
            $task_user_id = $tasksModel->where(['user_id' => $user_id])->first()['id'];
            $tasksModel->update($task_user_id, (object)['status' => $task_status]);
        }
    }
}
