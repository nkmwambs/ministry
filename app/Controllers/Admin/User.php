<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;


class User extends WebController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->model = new \App\Models\UsersModel();
    }

    public function fetchUsers()
    {
        $request = \Config\Services::request();

        // Get parameters sent by Datatables
        $draw = intval($request->getPost('draw'));
        $start = intval($request->getPost('start'));
        $length = intval($request->getPost('length'));
        $searchValue = $request->getPost('search')['value'];

        // Get the total number of records
        $totalRecords = $this->model
        ->join('auth_identities','auth_identities.user_id=users.id')
        ->where('auth_identities.type','email_password')
        ->countAll();

        // Apply search filter if provided
        if (!empty($searchValue)) {
            $this->model->like('first_name', $searchValue)
                ->orLike('last_name', $searchValue)
                ->orLike('phone', $searchValue)
                ->orLike('secret', $searchValue)
                ->orLike('active', $searchValue);
        }

        // Get the filtered total
        $totalFiltered = $this->model->countAllResults(false);

        // Limit the results and fetch the data
        $this->model->limit($length, $start);
        $data = $this->model
        ->select('users.id,users.first_name,users.last_name,users.phone,auth_identities.secret as email,users.active')
        ->join('auth_identities','auth_identities.user_id=users.id')
        ->where('auth_identities.type','email_password')
        ->find();

        // Loop through the data to apply hash_id()
        foreach ($data as &$user) {
            $user->hash_id = hash_id($user->id);  // Add hashed ID to each record
            // $user->active = $user->active == "1" ? 'Yes' : 'No';
        }

        // Prepare response data for DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $data,  // Now includes 'hash_id' in each record
        ];

        // Return JSON response
        return $this->response->setJSON($response);
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /// Posting Controllers

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
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $numeric_denomination_id = hash_id($this->request->getPost('denomination_id'), 'decode');

        // Generate random password with password hash in php 
        $password = $this->generateRandomString(8);
        $hashed_password = password_hash($this->generateRandomString(8), PASSWORD_DEFAULT);

        $templateLibrary =  new \App\Libraries\TemplateLibrary();
        $first_name = $this->request->getPost('first_name');
        $email = $this->request->getPost('email');
        $mailTemplate = $templateLibrary->getEmailTemplate(short_name: 'new_user_account', template_vars: compact('password', 'first_name', 'email'), denomination_id: $numeric_denomination_id);

        $logMailsModel = new \App\Models\LogmailsModel();
        // $logMailsModel->logEmails($email, $mailTemplate['subject'], $mailTemplate['body']);

        $data = [
            'denomination_id' => $numeric_denomination_id,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'roles' => json_encode($this->request->getPost('roles')),
            'permitted_entities' => json_encode($this->request->getPost('permitted_entities')) ?: NULL,
            'permitted_assemblies' => $this->request->getPost('permitted_assemblies') ?: NULL,
            'is_system_admin' => $this->request->getPost('is_system_admin') ?: NULL,
            'password' => $hashed_password,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        // $customFieldLibrary->saveCustomFieldValues(hash_id($insertId,'decode'), $this->tableName, $customFieldValues);

        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                $customFieldLibrary->saveCustomFieldValues(hash_id($insertId, 'decode'), $this->tableName, $customFieldValues);
            }
        }

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

            return view($this->session->user_type.'/user/list', $page_data);
        }

        return redirect()->to(site_url($this->session->user_type.'/users/view' . hash_id($insertId)));
    }

    /// Update Controllers
}
