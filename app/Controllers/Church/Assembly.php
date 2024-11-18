<?php

namespace App\Controllers\Church;

use App\Controllers\WebController;

class Assembly extends WebController
{
    function view($id): string{

        $page_data = $this->page_data();;
    
        $memberLibrary = new \App\Libraries\MemberLibrary();
        $collectionLibrary = new \App\Libraries\CollectionLibrary();
        $titheLibrary = new \App\Libraries\TitheLibrary();

        $page_data['columns']["member"] = $memberLibrary->setListQueryFields();
        $page_data['columns']["collection"] = $collectionLibrary->setListQueryFields();
        $page_data['columns']["tithe"] = $titheLibrary->setListQueryFields();

        return view('index', compact('page_data'));
    }
}
