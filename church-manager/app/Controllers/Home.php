<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends WebController
{

    protected $session = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
    }
    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            return $this->create_user_session($user->toArray());
        }

        return redirect()->to(site_url('/'));
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
        // Update log count
        $userModel = new \App\Models\UsersModel();
        $userModel->update($user['id'], (object)['access_count' => $user['access_count'] + 1]);

        return redirect()->to(site_url('dashboards'));
    }

}
