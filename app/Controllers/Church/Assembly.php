<?php

namespace App\Controllers\Church;

use App\Controllers\WebController;

class Assembly extends WebController
{
    function view($id): string{

        $page_data = $this->page_data();
    
        $memberLibrary = new \App\Libraries\MemberLibrary();
        $collectionLibrary = new \App\Libraries\CollectionLibrary();
        $titheLibrary = new \App\Libraries\TitheLibrary();

        $page_data['columns']["member"] = sanitizeColumns("members",$memberLibrary->setListQueryFields())['headerColumns'];
        $page_data['columns']["collection"] = sanitizeColumns("collections",$collectionLibrary->setListQueryFields())['headerColumns'];
        $page_data['columns']["tithe"] = sanitizeColumns("tithes",$titheLibrary->setListQueryFields())['headerColumns'];

        return view('index', compact('page_data'));
    }
}
