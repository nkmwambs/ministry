<?php 

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Login extends WebController {

    protected $session = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
    }

    // public function index() {
    //     // return view('dashboards');
    //     redirect()->to(site_url('dashboards'));
    // }

    // public function userValidate(): ResponseInterface {
    //     $email = $this->request->getPost('email');
    //     $user_password = $this->request->getPost('password');
        
    //     $userModel = new \App\Models\UsersModel();
    //     $user = $userModel->where(['email' => $email, 'is_active' => 'yes'])
    //     ->first();

    //     if (!$user || !password_verify($user_password, $user['password'])) {
    //         return redirect()->back()->withInput()->with('errors', 'Invalid login details');
    //     }else{
    //         return $this->create_user_session($user);
    //     }
    // }

    public function logout() {
        // $this->session->destroy();
        // return redirect()->to(site_url('/'));
        auth()->logout();
    }
}