<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Hierarchy extends BaseController
{
    protected $model = null;
    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\HierarchiesModel();
    }
    public function index($id = 0): string
    {
        $hierarchies = [];

        if($id > 0){
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, level, description')
            ->where('denomination_id',hash_id($id,'decode'))
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->orderBy('hierarchies.created_at desc')
            ->findAll();
        }else{
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, level, description')
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->orderBy('hierarchies.created_at desc')
            ->findAll();
        }
       
        if(!$hierarchies){
            $page_data['result'] = [];
        }else{
            $page_data['result'] = $hierarchies;
        }

        $page_data['result'] = $hierarchies;
        $page_data['feature'] = 'hierarchy';
        $page_data['action'] = 'list';
        
        if ($this->request->isAJAX()) {
            $page_data['id'] = $id;
            return view('hierarchy/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }

    public function add($id = 0): string {
        $page_data['feature'] = 'hierarchy';
        $page_data['action'] = 'add';
        return view('index', $page_data);
    }

    function post(){
        // log_message('error', json_encode($this->request->getPost()));
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]',
            'description'    => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        // log_message('error', json_encode($this->request->getPost()));
        $hashed_denomination_id = $this->request->getPost('denomination_id');
        $denomination_id = hash_id($hashed_denomination_id,'decode');

        $data = [
            'name' => $this->request->getPost('name'),
            'level' => $this->computeNextHierarchicalLevel($denomination_id),
            'denomination_id' => $denomination_id,
            'description' => $this->request->getPost('description'),
        ];

        // log_message('error', json_encode($data));

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'hierarchy';
            $this->action = 'list';
            $records = $this->model->orderBy("created_at desc")->where('denomination_id', $denomination_id)->findAll();
            $page_data = parent::page_data($records);
            $page_data['id'] = hash_id($denomination_id,'encode');
            // log_message('error', json_encode($page_data));
            // hashed_denomination_id
            return view("hierarchy/list", $page_data);
        }

        return redirect()->to(site_url("hierarchies/view/".hash_id($insertId)));
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');
        $hashed_denomination_id = $this->request->getVar('denomination_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[10]|max_length[255]',
            'email'    => 'required|valid_email|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), $update_data);

        if($this->request->isAJAX()){
            $this->feature = 'hierarchy';
            $this->action = 'list';

            $records = $this->model
            ->select('name,description')
            ->orderBy("created_at desc")
            ->where('denomination_id', hash_id($hashed_denomination_id,'decode'))
            ->findAll();
            return view("hierarchy/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("hierarchies/view/".$hashed_id))->with('message', 'Hierarchy updated successfully!');
    }

    private function computeNextHierarchicalLevel($denomination_id){
        $maxLevelObj = $this->model->selectMax('level')->where('denomination_id', $denomination_id)->first();
        $nextMaxLevel = $maxLevelObj['level'] + 1;
        return $nextMaxLevel;
    }

    public function getHierarchiesByDenominationId($hashed_denomination_id){
        // $hashed_denomination_id = $this->request->getVar('denomination_id');
        $denomination_id = hash_id($hashed_denomination_id,'decode');

        $hierarchies = $this->model->select('id,name')->where(['denomination_id' => $denomination_id, 'level <> ' => 1])->findAll();
        $hierarchies = array_map(function($elem){
            $elem['id'] = hash_id($elem['id'],"encode");
            $elem['name'] = plural($elem['name']);
             return $elem;
        }, $hierarchies );

        return response()->setJSON($hierarchies);
    }
}
