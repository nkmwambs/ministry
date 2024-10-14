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

    public function fetchHierarchies($parent_id) {
        
        $request = \Config\Services::request();

        // Get parameters sent by Datatables
        $draw = intval($request->getPost('draw'));
        $start = intval($request->getPost('start'));
        $length = intval($request->getPost('length'));
        $searchValue = isset($request->getPost('search')['value']) ? $request->getPost('search')['value'] : '';

        // Get the total number of records
        $totalRecords = $this->model->where('denomination_id', hash_id($parent_id, 'decode'))->countAllResults();

        // Apply search filter if provided
        $totalFiltered = $totalRecords;
        if (!empty($searchValue)) {
            $totalFiltered = $this->model->like('name', $searchValue)
                ->orLike('hierarchy_code', $searchValue)
                ->orLike('level', $searchValue)
                ->where('denomination_id', hash_id($parent_id, 'decode'))
                ->countAllResults(false);
        }


        // Limit the results and fetch the data
        $this->model->limit($length, $start);
        $data = $this->model->where('denomination_id', hash_id($parent_id, 'decode'))->find();

        // Loop through the data to apply hash_id()
        foreach ($data as &$hierarchy) {
            $hierarchy['hash_id'] = hash_id($hierarchy['id']);  // Add hashed ID to each record
        }

        // Prepare response data for DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $data,  // Now includes 'hash_id' in each record
        ];

        // Return JSON response
        return $this->response->setJSON($response);
    }
    public function index($parent_id = 0): string
    {
        // Parent Id the denomination primary key of hierarchies

        // $hierarchies = [];

        // if($parent_id > 0){
        //     $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, hierarchies.hierarchy_code, level, description')
        //     ->where('denomination_id',hash_id($parent_id,'decode'))
        //     ->join('denominations','denominations.id=hierarchies.denomination_id')
        //     ->orderBy('hierarchies.created_at desc')
        //     ->findAll();
        // }else{
        //     $hierarchies = $this->model->select('hierarchies.id,hierarchies.name, hierarchies.hierarchy_code, level, description')
        //     ->join('denominations','denominations.id=hierarchies.denomination_id')
        //     ->orderBy('hierarchies.created_at desc')
        //     ->findAll();
        // }
       
        // if(!$hierarchies){
        // $page_data['result'] = [];
        // }else{
            // $page_data['result'] = $hierarchies;
        // }

        $page_data['result'] = ['hierarchy.hierarchy_action','hierarchy.hierarchy_name','hierarchy.hierarchy_code', 'hierarchy.hierarchy_description', 'hierarchy.hierarchy_level']; //$hierarchies;
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
        $customFieldLibrary->saveCustomFieldValues(hash_id($insertId,'decode'), $this->tableName, $customFieldValues);

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
        $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,'decode'), $this->tableName, $customFieldValues);

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
