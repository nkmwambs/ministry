<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;


class Modal extends WebController
{
    // public function index()
    // {
    //     //
    // }

    function load(){
        $viewData = [
            'title' => 'Modal',
            'content' => view('modals')
        ];

        return view($this->session->user_type.'/layouts/main', $viewData);
    }
}
