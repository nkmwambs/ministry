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

    public function saveTask() {
        $insertID = 0;
        // $validation = \Config\Services::validation();
        // $validation->setRules([
        //     'user_id' => [
        //         'rules' => 'required',
        //         'label' => 'User Name',
        //         'errors' => [
        //             'required' => 'Department Name is required'
        //         ]
        //     ],
        //     'name' => [
        //         'rules'=> 'required|min_length[5]|max_length[255]',
        //         'label' => 'Name',
        //         'errors' => [
        //             'required' => 'Role Name is required',
        //             'min_length' => 'Role Name must be at least {value} characters long',
        //             'max_length' => 'Role Name cannot exceed {value} characters long',
        //             // 'alpha_space' => 'Role field can only contain alphabetic characters and spaces.',
        //         ]
        //     ],
        // ]);

        $numeric_user_id = hash_id($this->request->getPost('user_id'), 'decode');
        $data = [
            'name' => $this->request->getPost('taskName'),
            'user_id' => $numeric_user_id,
        ];

        $db = db_connect();
        $builder = $db->table('tasks');
        $builder->insert($data);
        $insertID = $db->insertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'task';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            $this->parent_id =  $this->request->getPost('user_id');
            $this->id =  hash_id($insertID, 'encode');

            return view('task/list', parent::page_data($records));
        }
    
        return redirect()->to(site_url('users/profile' . hash_id($insertID)))->with('message', 'Role added successfully!');
    }

    public function updateTask() {
        $hashed_id = $this->request->getVar('id');

        // Validations

        $update_data = [
            'name' => $this->request->getPost('name'),
            'status' => $this->request->getPost('status'),
            'user_id' => $this->request->getPost('user_id')
        ];

        // $db = db_connect();
        // $builder = $db->table('tasks');

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

        if ($this->request->isAJAX()) {
            $this->feature = 'task';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            $this->parent_id =  $this->request->getPost('user_id');

            return view('task/list', parent::page_data($records));
        }
        return redirect()->to(site_url('users/profile' . $hashed_id))->with('message', 'Role updated successfully!');
    }

    public function updateTaskStatus() {

        $statusesModel = new \App\Models\StatusesModel();
        $user_id = $this->request->getPost('user_id');
        $task_status = $this->request->getPost('status');

        $countTaskStatuses = $statusesModel->where('user_id', $user_id)->countAllResults();
        // log_message('error', json_encode($countTaskStatuses));
        if ($countTaskStatuses == 0) {
            $this->model->insert((object)['status' => $this->request->getPost('status')]);
        } else {
            $task_id = $statusesModel->where('user_id', $user_id)->first()['id'];
            // log_message('error', json_encode($task_id));
            $statusesModel->update($task_id, (object)['status' => $task_status]);
        }
    }  

    function getTaskStatuses($task_id){
        $task_statuses = $this->model->where('id', $task_id)->first()['status'];
        return $this->response->setJSON(compact('status'));
    }
}
