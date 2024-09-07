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

    public function getEntitiesWithValues()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('entities');
        $builder->select('entities.id, entities.name, hierarchies.name, hierarchies.hierarchy_id');
        $builder->join('entity_values', 'entity_values.entity_id = entities.id', 'left'); // Adjust based on your structure
        $results = $builder->get()->getResult();

        // $entitiesModel = new \App\Models\EntitiesModel();
        // $results = $entitiesModel->select('entities.id, entities.name, entity_values.value')
        //     ->join('entity_values', 'entity_values.entity_id = entities.id', 'left')->get()->getAllResult();

        // Prepare data to pass to the view
        $entities = [];
        foreach ($results as $result) {
            $entities[] = [
                'id' => $result->id,
                'name' => $result->name,
                'value' => $result->value
            ];
        }

        // Pass the entities data to the view
        // return view('add_user', parent::page_data($entities));
    }

    public function getHierarchiesWithEntities()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('hierarchies');
        $builder->select('hierarchies.id as hierarchy_id, hierarchies.name as hierarchy_name, entities.id as entity_id, entities.name as entity_name');
        $builder->join('entities', 'entities.hierarchy_id = hierarchies.id');
        $results = $builder->get()->getResult();

        // Initialize an array to hold hierarchy data
        $hierarchies = [];
        foreach ($results as $row) {
            if (!isset($hierarchies[$row->hierarchy_name])) {
                $hierarchies[$row->hierarchy_name] = [];
            }
            $hierarchies[$row->hierarchy_name][] = [
                'id' => $row->entity_id,
                'name' => $row->entity_name
            ];
        }

        // Pass the structured hierarchies to the view
        return view('user/add', ['hierarchies' => $hierarchies]);
    }
}
