<?php

namespace App\Controllers\Church;

use App\Controllers\WebController;
use CodeIgniter\I18n\Time;

class User extends WebController
{
    public function view($hashed_id): string {
        $data = [];
        $numeric_id = hash_id($hashed_id, 'decode');

        if (method_exists($this->model, 'getViewData')) {
            $data = $this->model->getViewData($numeric_id);
        } else {
            $data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $hashed_id;
        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'viewExtraData')) {
            $this->library->viewExtraData($page_data);
        }

        if (
            isset($data) && 
            is_array($data) && 
            array_key_exists('id',$data)
        ) {
            unset($data['id']);
        }

        if ($this->request->isAjax()) {
            return view($this->session->get('user_type') . "/$this->feature/view", $page_data);
        }

        return view('index', compact('page_data'));
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

            return view($this->session->user_type.'/user/account', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->user_type.'/users/view/' . $hashed_id))->with('message', 'User Public Info updated successfuly!');
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

            return view($this->session->user_type.'/user/account', parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->user_type.'/users/view/' . $hashed_id))->with('message', 'User Private Info updated successfuly!');
    }
}
