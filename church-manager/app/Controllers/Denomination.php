<?php

namespace App\Controllers;

class Denomination extends BaseController
{
    public function index(): string
    {
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'list';
        return view('index', $page_data);
    }

    public function add(): string {
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'add';
        return view('index', $page_data);
    }

    public function view(): string {
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'view';
        return view('index', $page_data);
    }

    public function edit(): string {
        $page_data['feature'] = 'denomination';
        $page_data['action'] = 'edit';
        return view('index', $page_data);
    }
}
