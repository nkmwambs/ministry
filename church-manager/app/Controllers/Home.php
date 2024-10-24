<?php

namespace App\Controllers;

class Home extends WebController
{
    public function index()
    {
        return redirect()->to(site_url('dashboards'));
    }

}
