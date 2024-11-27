<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\I18n\Time;

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
        // $hashed_password = password_hash($this->generateRandomString(8), PASSWORD_DEFAULT);

        $templateLibrary =  new \App\Libraries\TemplateLibrary();
        $first_name = $this->request->getPost('first_name');
        $email = $this->request->getPost('email');
        $mailTemplate = $templateLibrary->getEmailTemplate(short_name: 'new_user_account', template_vars: compact('password', 'first_name', 'email'), denomination_id: $numeric_denomination_id);

        $logMailsModel = new \App\Models\LogmailsModel();
        $logMailsModel->logEmails($email, $mailTemplate['subject'], $mailTemplate['body']);

        $data = [
            'denomination_id' => $numeric_denomination_id,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'active' => 1,
            'gender' => $this->request->getPost('gender'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'roles' => json_encode($this->request->getPost('roles')),
            'email' => $this->request->getPost('email'),
            'permitted_entities' => json_encode($this->request->getPost('permitted_entities')) ?: NULL,
            'permitted_assemblies' => $this->request->getPost('permitted_assemblies') ? json_encode($this->request->getPost('permitted_assemblies')) : NULL,
            'is_system_admin' => $this->request->getPost('is_system_admin') ?: NULL,
            'password' => $password,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $user = new \CodeIgniter\Shield\Entities\User($data);

        $this->model->insert($user);
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

            return view($this->session->get('user_type').'/user/list', $page_data);
        }

        return redirect()->to(site_url($this->session->get('user_type').'/users/view' . hash_id($insertId)));
    }

    /// Update Controllers

    public function updatePublicInfo()
    {
        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[255]',
            'biography' => 'required|min_length[3]|max_length[255]',
            // 'profile_picture' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $originalDate = Time::now('America/Chicago', 'en_US');
        $newDateString = $originalDate->format('Y-m-d H:i:s');

        $update_data = [
            'username' => $this->request->getPost('username'),
            'biography' => $this->request->getPost('biography'),
            'updated_at' => $newDateString,
            // 'profile_picture' => $this->request->getPost('profile_picture')?: NULL, // This line prevents NULL values from being inserted into the database. It should be handled elsewhere in your application. If you want to remove this line, make sure to handle NULL values appropriately in your application.
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

        if ($this->request->isAJAX() > 0) {
            $this->feature = 'user';
            $this->action = 'list';

            $records = [];

            if(method_exists($this->model, 'getViewData')){
                $records = $this->model->getViewData(hash_id($hashed_id, 'decode'));
            }else{
                $records = $this->model->getOne(hash_id($hashed_id, 'decode'));
            }

            return view($this->session->get('user_type').'/user/account', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type').'/users/view/' . $hashed_id))->with('message', 'User Public Info updated successfuly!');
    }

    public function updatePrivateInfo()
    {
        $hashed_id = $this->request->getPost('id'); // hash_id($id, 'decode');

        $validation = \Config\Services::validation();
        $validation->setRules([
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

        $originalDate = Time::now('America/Chicago', 'en_US');
        $newDateString = $originalDate->format('Y-m-d H:i:s');

        $update_data = [
            // 'denomination_id' => $this->request->getPost('denomination_id'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'updated_at' => $newDateString,
        ];

        $this->model->update(hash_id($hashed_id, 'decode'), (object)$update_data);

        if ($this->request->isAJAX() > 0) {
            $this->feature = 'user';
            $this->action = 'list';

            $records = [];

            if (method_exists($this->model, 'getAll')) {
                $records = $this->model->getAll();
            } else {
                $records = $this->model->findAll();
            }

            return view($this->session->get('user_type').'/user/account', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type').'/users/view/' . $hashed_id))->with('message', 'User Private Info updated successfuly!');
    }




    public function getAccount($id)
    {
        $numeric_id = hash_id($id, 'decode');

        if (method_exists($this->model, 'getViewData')) {
            $data = $this->model->getViewData($numeric_id);
        } else {
            $data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $id;

        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'editExtraData')) {
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }

        return view($this->session->get('user_type').'/user/account', $page_data);
    }

    function passwordVerify()
    {
        $user_password = $this->request->getPost('user_password');
        $user_id = $this->request->getPost('user_id');
        $numeric_user_id = hash_id($user_id, 'decode');

        $user = $this->model->find($numeric_user_id);

        $validPassword = false;
        if ($user) {
            $current_password = addslashes($user['password']);
            $validPassword = password_verify(trim($user_password), $current_password);
        }

        return response()->setJSON(['success' => $validPassword]);
    }

    public function passwordReset($id)
    {
        $numeric_id = hash_id($id, 'decode');

        if (method_exists($this->model, 'getEditData')) {
            $data = $this->model->getEditData($numeric_id);
        } else {
            $data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $id;

        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'editExtraData')) {
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }
        // return redirect()->to(site_url('users/profile/account' . $hashed_id))->with('message', 'User Private Info updated successfuly!');
        return view($this->session->get('user_type').'/user/password_reset', $page_data);
    }

    public function privacy()
    {
        return view($this->session->get('user_type').'/user/privacy');
    }

    public function emailNotifications()
    {
        return view($this->session->get('user_type').'/user/email_notification');
    }

    public function pendingTasks($user_id)
    {
        $tasks = [];

        $tasksModel = new \App\Models\TasksModel();

        if ($user_id > 0) {
            $tasks = $tasksModel->select('tasks.id,tasks.name,tasks.status')
                ->where('tasks.user_id', hash_id($user_id, 'decode'))
                ->join('users', 'users.id = tasks.user_id')
                ->orderBy('tasks.created_at asc')->findAll();
        } else {
            $tasks = $tasksModel->select('tasks.id,tasks.name,tasks.status')
                ->join('users', 'users.id = tasks.user_id')
                ->orderBy('tasks.created_at asc')->findAll();
        }

        if (!$tasks) {
            $page_data['result'] = [];
        } else {
            $page_data['result'] = $tasks;
        }

        $page_data['result'] = $tasks;
        $page_data['feature'] = 'task';
        $page_data['action'] = 'list';
        $page_data['parent_id'] = $user_id;

        // Load the view and pass the data
        return view($this->session->get('user_type').'/task/list', $page_data);
    }

    public function widgets()
    {
        return view($this->session->get('user_type').'/user/widget');
    }

    public function yourData($id)
    {
        $numeric_id = hash_id($id, 'decode');

        if (method_exists($this->model, 'getEditData')) {
            $user_data = $this->model->getEditData($numeric_id);
        } else {
            $user_data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $id;

        $page_data = $this->page_data($user_data);
        if (method_exists($this->library, 'editExtraData')) {
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }
        return view($this->session->get('user_type').'/user/your_data', $page_data);
    }

    public function downloadUserDataPdf($user_id)
    {
        $user_data = $this->model->getOne($user_id);
        $user_data = formatUserDataForExport($user_data);

        $this->parent_id = $user_id;

        $userLibrary = new \App\Libraries\UserLibrary();
        $userLibrary->exportUserDataToPdf($user_data);

        return view($this->session->get('user_type').'/user/your_data');
    }


    public function deleteAccount()
    {
        return view($this->session->get('user_type').'/user/delete_account');
    }

    public function deleteMyAccount($userId)
    {
        // Delete the user account
        if ($this->model->delete($userId)) {
            // Optionally, you can handle session destruction after account deletion
            session()->destroy();

            return redirect()->to('/')->with('message', 'Account successfully deleted');
        } else {
            return redirect()->back()->with('error', 'Failed to delete account');
        }
    }
}
