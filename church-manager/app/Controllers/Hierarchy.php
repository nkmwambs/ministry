<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Hierarchy extends WebController
{
    protected $model = null;
    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\HierarchiesModel();
    }
    public function index($parent_id = 0): string
    {
        // Parent Id the denomination primary key of hierarchies

        if(!auth()->user()->canDo("$this->feature.read")){
            $page_data = $this->page_data(['errors' =>  []]);

            if ($this->request->isAJAX()) {
                return view("errors/html/error_403", $page_data);
            }

            return view('index', compact('page_data'));
        }
        
        $hierarchies = [];

        if($parent_id > 0){
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, hierarchies.hierarchy_code, level, description')
            ->where('denomination_id',hash_id($parent_id,'decode'))
            ->join('denominations','denominations.id=hierarchies.denomination_id')
            ->orderBy('hierarchies.created_at desc')
            ->findAll();
        }else{
            $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, hierarchies.hierarchy_code, level, description')
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
            $denominationsModel = new \App\Models\DenominationsModel();
            $page_data['parent_id'] = $parent_id; 
            $page_data['number_of_denomination_assemblies'] = $denominationsModel->getDenominationAssembliesCount(hash_id($parent_id,'decode'));
            return view('hierarchy/list', $page_data);
        }else{
            $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
        }

        return view('index', $page_data);
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]',
            'hierarchy_code' => 'required|max_length[2]|max_length[10]',
            'description'    => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $hashed_denomination_id = $this->request->getPost('denomination_id');
        $denomination_id = hash_id($hashed_denomination_id,'decode');
        // log_message('error',$denomination_id);

        // Get Denomination Code
        $denominationModel = new \App\Models\DenominationsModel();
        $denomination_code = $denominationModel->find($denomination_id)['code'];

        $data = [
            'name' => $this->request->getPost('name'),
            'hierarchy_code' => $denomination_code.'/'.strtoupper($this->request->getPost('hierarchy_code')),
            'level' => $this->computeNextHierarchicalLevel($denomination_id),
            'denomination_id' => $denomination_id,
            'description' => $this->request->getPost('description'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        // $customFieldLibrary->saveCustomFieldValues(hash_id($insertId,'decode'), $this->tableName, $customFieldValues);

        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                $customFieldLibrary->saveCustomFieldValues(hash_id($insertId,'decode'), $this->tableName, $customFieldValues);
            }
        }

        $this->parent_id = $hashed_denomination_id;

        if($this->request->isAJAX()){
            $denominationsModel = new \App\Models\DenominationsModel();

            $this->feature = 'hierarchy';
            $this->action = 'list';
            $data = $this->model->orderBy("created_at desc")->where('denomination_id', $denomination_id)->findAll();

            $page_data = parent::page_data($data, $hashed_denomination_id);
            $page_data['number_of_denomination_assemblies'] = $denominationsModel->getDenominationAssembliesCount(hash_id($hashed_denomination_id,'decode'));

            return view("hierarchy/list", $page_data);
        }

        return redirect()->to(site_url("hierarchies/view/".hash_id($insertId)));
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');
        $hashed_denomination_id = $this->request->getVar('denomination_id');


        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]',
            'description'    => 'required|max_length[255]',
            'hierarchy_code' => 'required|max_length[255]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'hierarchy_code' => $this->request->getPost('hierarchy_code'),
        ];

        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        // $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,dir: 'decode'), $this->tableName, $customFieldValues);

        // Only save custom fields if they are not null
        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,dir: 'decode'), $this->tableName, $customFieldValues);
            }
        }

        $customFieldValuesInDB = $customFieldLibrary->getCustomFieldValuesForRecord(hash_id($hashed_id,dir: 'decode'), 'users');

        if($this->request->isAJAX()){
            $this->feature = 'hierarchy';
            $this->action = 'list';

            $records = $this->model
            ->select('id,name,hierarchy_code,description,level')
            ->orderBy("created_at desc")
            ->where('denomination_id', hash_id($hashed_denomination_id,'decode'))
            ->findAll();

            $denominationsModel = new \App\Models\DenominationsModel();
            $page_data = parent::page_data($records, $hashed_denomination_id);
            $page_data['parent_id'] = $hashed_denomination_id;
            $page_data['number_of_denomination_assemblies'] = $denominationsModel->getDenominationAssembliesCount(hash_id($hashed_denomination_id,'decode'));

            return view("hierarchy/list", $page_data);
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

    public function getAllHierarchiesByDenominationId($hashed_denomination_id){
        // $hashed_denomination_id = $this->request->getVar('denomination_id');
        $denomination_id = hash_id($hashed_denomination_id,'decode');

        $hierarchies = $this->model->select('id,name')->where(['denomination_id' => $denomination_id])->findAll();
        // $hierarchies = array_map(function($elem){
        //     $elem['id'] = hash_id($elem['id'],"encode");
        //     $elem['name'] = plural($elem['name']);
        //      return $elem;
        // }, $hierarchies );

        return response()->setJSON($hierarchies);
    }
}
