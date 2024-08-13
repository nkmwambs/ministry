<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $page_data['users'] = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
            ['name' => 'Alice Doe', 'email' => 'alice@example.com'],
        ]; 

        return view('index', $page_data);
    }

}
