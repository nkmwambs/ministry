<?php

namespace App\Controllers;


class Modal extends WebController
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
