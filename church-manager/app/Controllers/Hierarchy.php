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
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, level')
            ->where('denomination_id',hash_id($id,'decode'))
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->orderBy('hierarchies.created_at desc')
            ->findAll();
        }else{
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, level')
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
        $insertId = 0;

        // $validation = \Config\Services::validation();
        // $validation->setRules([
        //     'name' => 'required|min_length[10]|max_length[255]',
        //     'email'    => 'required|valid_email|max_length[255]',
        //     'code' => 'required|min_length[3]',
        // ]);

        // if (!$this->validate($validation->getRules())) {
        //     return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        // }

        $denomination_id = hash_id($this->request->getPost('denomination_id'),'decode');

        $data = [
            'name' => $this->request->getPost('name'),
            'level' => $this->computeNextHierarchicalLevel($denomination_id),
            'denomination_id' => $denomination_id,
            'description' => $this->request->getPost('description'),
        ];

        $this->model->insert($data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'hierarchy';
            $this->action = 'list';
            $records = $this->model->orderBy("created_at desc")->where('denomination_id', $denomination_id)->findAll();
            $page_data = parent::page_data($records);
            $page_data['id'] = hash_id($denomination_id,'encode');
            // log_message('error', json_encode($page_data));
            return view("hierarchy/list", $page_data);
        }

        return redirect()->to(site_url("denominations/view/".hash_id($insertId)));
    }

    private function computeNextHierarchicalLevel($denomination_id){
        $maxLevel = $this->model->selectMax('level')->where('denomination_id', $denomination_id)->first();
        return $maxLevel['level'] + 1;
    }
}
