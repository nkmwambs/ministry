<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Minister extends BaseController
{
    private $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\MinistersModel();
    }

    public function index()
    {
        // $ministers = $this->model->get_ministers();
        $ministers = $this->model->select('name, minister_number,assembly_id,designation_id,phone')
        ->join('designations', 'designations.id = ministers.designation_id')
        ->join('assemblies', 'assemblies.id = ministers.assembly_id')
        ->findAll();

        $page_data["result"] = $ministers;
        $page_data['feature'] = 'minister';
        $page_data['action'] = 'list';

        return view('index', $page_data);
    }

    public function add(): string {
        $page_data['feature'] = 'minister';
        $page_data['action'] = 'add';

        return view('index', $page_data);
    }

    public function edit(): string {
        $id = $this->request->getVar('id');
        $minister = $this->model->select('name, minister_number,assembly_id,designation_id,phone')
        ->where('id', hash_id($id, 'decode'))
        ->first();

        $page_data['result'] = $minister;
        $page_data['feature'] ='minister';
        $page_data['action'] = 'edit';

        return view('index', $page_data);
    }

    public function update($id) {
        $data = [
            'name' => $this->request->getPost('name'),
            'minister_number' => $this->request->getPost('minister_number'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'designation_id' => $this->request->getPost('designation_id'),
            'phone' => $this->request->getPost('phone'),
        ];

        $this->model->update(hash_id($id, 'decode'), $data);

        return redirect()->to(site_url("ministers/view/".$id));
    }

    public function post() {
        $insertId = 0;

        $data = [
            'name' => $this->request->getPost('name'),
            'minister_number' => $this->request->getPost('minister_number'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'designation_id' => $this->request->getPost('designation_id'),
            'phone' => $this->request->getPost('phone'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        return redirect()->to(site_url("ministers/view".hash_id($insertId)));
    }
}
