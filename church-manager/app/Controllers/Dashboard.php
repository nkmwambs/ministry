<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $page_data['feature'] = 'dashboard';
        $page_data['action'] = 'list';
        return view('index', $page_data);
    }

}
