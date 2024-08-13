<?php 

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Login extends BaseController {

    private $session = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
    }

    public function index() {
        return view('users/login');
    }

    public function userValidate(): ResponseInterface {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validate user credentials
        if($email == 'johndoe@gmail.com' && $password == 'password'){
            $this->session->set('logged_in', true);
            return redirect()->to(site_url('dashboards'));
        } else {
            return redirect()->to(site_url('/'));
        }
    }

    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }
}