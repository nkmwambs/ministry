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
    public function index($id = null)
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            return $this->create_user_session($user->toArray());
        }
        
        // auth()->loggedout();
        return redirect()->to(site_url('login'));
    }

    private function create_user_session($user) {
        
        $this->session->set('logged_in', true);
        $this->session->set('user_id', $user['id']);
        $this->session->set('user_type', $user['user_type']);
        $this->session->set('user_fullname', $user['first_name']." ". $user['last_name']);
        $this->session->set('user_roles', $user['roles']!= NULL ? explode(',',$user['roles']) : []);
        $this->session->set('user_denomination_id', $user['denomination_id']);
        $this->session->set('user_is_system_admin', $user['is_system_admin']);
        $this->session->set('user_permitted_entities', $user['permitted_entities'] != NULL ? json_decode($user['permitted_entities']): []);
        $this->session->set('user_permitted_assemblies', $user['permitted_assemblies'] != NULL ? json_decode($user['permitted_assemblies']): []);

        // Update log count
        $userModel = new \App\Models\UsersModel();
        $userModel->update($user['id'], (object)['access_count' => $user['access_count'] + 1]);

        // Check if a member role is available or create a new one
        if (!$this->checkMemberRole()) {
            $this->createMemberRole();
        }

        return redirect()->to(site_url($this->session->get('user_type').'/dashboards/list'));
    }

    private function checkMemberRole() {
        $roleModel = new \App\Models\RolesModel();
        $memberRole = $roleModel->where('name', 'member')->first();
        return $memberRole!= NULL;
    }

    private function createMemberRole() {
        $roleModel = new \App\Models\RolesModel();
        $roleModel->insert((object)['name' =>'member', 'default_role' => 'yes', 'permissions' => '["dashboard.read"]']);
    }

    public function logout() {
        $this->session->destroy();
        // auth()->logout();
        return redirect()->to(site_url('/'));    
    }

}
