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
    
        return redirect()->to(site_url('users/profile' . hash_id($insertID)))->with('message', 'Task added successfully!');
    }

    public function updateStatus()
    {
        $numeric_id = $this->request->getPost('id');

        $task_status = [
            'status' => $this->request->getPost('status')
        ];

        $this->model->save($this->request->getPost());

        if ($this->request->isAJAX()) {
            $this->feature = 'task';
            $this->action = 'list';

            $records = [];
            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            $this->parent_id = $this->request->getPost('user_id');

            return view('task/list', parent::page_data($records));
        }

        return redirect()->to(site_url('users/profile' . hash_id($numeric_id, 'encode')))->with('message', 'Task Status updated successfully!');
    }

    function getTaskStatuses($task_id){
        $task_statuses = $this->model->where('id', $task_id)->first()['status'];
        return $this->response->setJSON(compact('status'));
    }
}
