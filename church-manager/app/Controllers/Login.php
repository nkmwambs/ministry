<?php 

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Login extends BaseController {

    protected $session = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
    }

    public function index(): string {
        return view('user/login');
    }

    public function userValidate(): ResponseInterface {
        $email = $this->request->getPost('email');
        $user_password = $this->request->getPost('password');
        
        $userModel = new \App\Models\UsersModel();
        $user = $userModel->where(['email' => $email, 'is_active' => 'yes'])
        ->first();

        if (!$user || !password_verify($user_password, $user['password'])) {
            return redirect()->back()->withInput()->with('errors', 'Invalid login details');
        }else{
            return $this->create_user_session($user);
        }
    }

    private function create_user_session($user) {
        
        $this->session->set('logged_in', true);
        $this->session->set('user_id', $user['id']);
        $this->session->set('user_fullname', $user['first_name']." ". $user['last_name']);
        $this->session->set('user_roles', explode(',',$user['roles']));
        $this->session->set('user_denomination_id', $user['denomination_id']);
        $this->session->set('user_is_system_admin', $user['is_system_admin']);
        $this->session->set('user_permitted_entities', explode(',',$user['permitted_entities']));
        $this->session->set('user_permitted_assemblies', explode(',',$user['permitted_assemblies']));
        
        return redirect()->to(site_url('dashboards'));
    }

    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }
}