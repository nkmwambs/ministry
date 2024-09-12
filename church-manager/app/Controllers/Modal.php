<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Modal extends BaseController
{
    public function index()
    {
        //
    }

    function load(){
        $viewData = [
            'title' => 'Modal',
            'content' => view('modals')
        ];

        return view('layouts/main', $viewData);
    }
}
