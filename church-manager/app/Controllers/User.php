<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class User extends BaseController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\UsersModel();
    }

    public function post()
    {
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'denomination_id' => 'required',
            'first_name' => 'required|min_length[3]|max_length[255]',
            'last_name' => 'required|min_length[3]|max_length[255]',
            'phone' => 'required',
            'email' => 'required|valid_email',
            'gender' => 'required|min_length[4]|max_length[6]',
            'date_of_birth' => 'required',
            'roles' => 'required',
            'access_count' => 'required',
            'associated_member_id' => 'required',
            'permitted_entities' => 'required',
            'permitted_assemblies' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $data = [
            'denomination_id' => $this->request->getPost('denomination_id'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'roles' => $this->request->getPost('roles'),
            'access_count' => $this->request->getPost('access_count'),
            'associated_member_id' => $this->request->getPost('associated_member_id'),
            'permitted_entities' => $this->request->getPost('permitted_entities'),
            'permitted_assemblies' => $this->request->getPost('permitted_assemblies'),
            'is_system_admin' => $this->request->getPost('is_system_admin'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if ($this->request->isAJAX()) {
            $this->feature = 'user';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            $page_data = parent::page_data($records);

            return view('user/list', $page_data);
        }

        return redirect()->to(site_url('users/view' . hash_id($insertId)));
    }

    public function update($id)
    {
        $hashed_id = $this->request->getPost('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'denomination_id' => 'required',
            'first_name' => 'required|min_length[3]|max_length[255]',
            'last_name' => 'required|min_length[3]|max_length[255]',
            'phone' => 'required',
            'email' => 'required|valid_email',
            'gender' => 'required|min_length[4]|max_length[6]',
            'date_of_birth' => 'required',
            'roles' => 'required',
            'access_count' => 'required',
            'associated_member_id' => 'required',
            'permitted_entities' => 'required',
            'permitted_assemblies' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $update_data = [
            'denomination_id' => $this->request->getPost('denomination_id'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'roles' => $this->request->getPost('roles'),
            'access_count' => $this->request->getPost('access_count'),
            'associated_member_id' => $this->request->getPost('associated_member_id'),
            'permitted_entities' => $this->request->getPost('permitted_entities'),
            'permitted_assemblies' => $this->request->getPost('permitted_assemblies'),
            'is_system_admin' => $this->request->getPost('is_system_admin'),
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

        if ($this->model->isAJAX() > 0) {
            $this->feature = 'user';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view('user/list', parent::page_data($records));
        }

        return redirect()->to(site_url('users/view' . $hashed_id))->with('message', 'User updated successfuly!');
    }

    public function store()
    {
        $permitted_entities = $this->request->getVar('permitted_entities');
        $name = $this->request->getVar('name');

        // Save user
        $this->model->save([
            'name' => $name,
            'permitted_entities' => json_encode($permitted_entities)
        ]);

        return redirect()->to('/users');
    }
    
    // Method to fetch hierarchies and entities for select2
    // public function getHierarchiesWithEntities()
    // {
    //     $searchTerm = $this->request->getVar('searchTerm');
    //     // Get hierarchies from the database
    //     $hierarchiesModel = new \App\Models\HierarchiesModel();
    //     $hierarchies = $hierarchiesModel->like('name', $searchTerm)->findAll();

    //     $data = [];

    //     // Loop through hierarchies and attach entities
    //     foreach ($hierarchies as $hierarchy) {
    //         $entitiesModel = new \App\Models\EntitiesModel();
    //         $entities = $entitiesModel->where('hierarchy_id', $hierarchy['id'])
    //         ->like('name', $searchTerm)->findAll();

    //         // Format the data for Select2
    //         $data[] = [
    //             'id' => $hierarchy['id'],
    //             'text' => $hierarchy['name'],
    //             'children' => array_map(function ($entity) {
    //                 return [
    //                     'id' => $entity['id'],
    //                     'text' => $entity['name']
    //                 ];
    //             }, $entities)
    //         ];
    //     }

    //     // Return as JSON for the AJAX response
    //     return $this->response->setJSON($data);
    // }
}
