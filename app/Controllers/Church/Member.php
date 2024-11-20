<?php

namespace App\Controllers\Church;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;

class Member extends WebController
{
    function view($id): string {
        
        $numeric_id = hash_id($id, 'decode');

        $data = [];
        if (method_exists($this->model, 'getViewData')) {
            $data = $this->model->getViewData($numeric_id);
        } else {
            $data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $id;
        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'viewExtraData')) {
            $this->library->viewExtraData($page_data);
        }

        if (
            isset($data) && 
            is_array($data) && 
            array_key_exists('id',$data)
        ) {
            unset($data['id']);
        }

        if ($this->request->isAjax()) {
            return view($this->session->user_type . "/$this->feature/view", $page_data);
        }

        return view('index', compact('page_data'));
    }
}
