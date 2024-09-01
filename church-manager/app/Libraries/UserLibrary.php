<?php 

namespace App\Libraries;
use App\Interfaces\LibraryInterface;
use App\Models\UsersModel;

class UserLibrary implements LibraryInterface {
    protected $userModel;
    protected $session;
    
    public function __construct() {
        $this->userModel = new UsersModel();
        $this->session = session();
    }

    public function login($email, $password) {
        $user = $this->userModel->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            $this->session->set([
                'user_id' => $user['id'],
                'is_system_admin' => $user['is_system_admin'],
                'logged_in' => true,
            ]);
            return true;
        }

        return false;
    }

    public function logout() {
        $this->session->destroy();
    }

    public function isLoggedIn() {
        return $this->session->get('logged_in') === true;
    }

    public function isSystemAdmin() {
        return $this->session->get('is_system_admin') === 'yes';
    }
    
    public function getUser() {
        if ($this->isLoggedIn()) {
            return $this->userModel->find($this->session->get('user_id'));
        }

        return null;
    }

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ["id","denomination_id","first_name","last_name","phone","email","gender","password","roles","is_system_admin"];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ["id","denomination_id","first_name","last_name","phone","email","gender","password","roles","is_system_admin"];
        return $fields;
    }
}