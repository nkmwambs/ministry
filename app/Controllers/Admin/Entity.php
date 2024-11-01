<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;

class Entity extends WebController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\EntitiesModel();
    }
    public function index($hashed_id = ''): string
    {

        if(!auth()->user()->canDo("$this->feature.read")){
            $page_data = $this->page_data(['errors' =>  []]);

            if ($this->request->isAJAX()) {
                return view("errors/html/error_403", $page_data);
            }

            return view('index', compact('page_data'));
        }

        $entities = [];
        $hierarchy_id = hash_id($hashed_id,'decode');

        if($hashed_id != ''){
            $entities = $this->model
            ->where('entities.hierarchy_id', $hierarchy_id)
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy('entities.created_at desc')
            ->findAll();
        }else{
            $entities = $this->model
            ->where('entities.hierarchy_id', $hierarchy_id)
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy('entities.created_at desc')
            ->findAll();
        }

        $page_data['result'] = $entities;
        $page_data['feature'] = 'entity';
        $page_data['action'] = 'list';

        if($this->request->isAJAX()){
            $page_data['parent_id'] = $hashed_id;
            return view($this->session->user_type.'/entity/list', $page_data);
        }
        return view('index', $page_data);
    }

    public function add(): string {
        $page_data = parent::page_data();
        if(method_exists($this->library, 'getLookUpItems')){
            $this->library->getLookUpItems($page_data);
        }

        foreach ((object)$this->tableName as $table_name) {
            $customFieldLibrary = new \App\Libraries\FieldLibrary();
            $customFields = $customFieldLibrary->getCustomFieldsForTable($table_name);
            $page_data['customFields'] = $customFields;
            // log_message('error', json_encode($customFields));
        }
        
        return view($this->session->user_type.'/entity/add', $page_data);
    }

    public function edit(): string {
        $numeric_id = hash_id($this->id, 'decode');
        $data = $this->model->getOne(hash_id($this->id,'decode'));

        $this->parent_id = hash_id($data['hierarchy_id'],'encode');
        
        $page_data = $this->page_data($data);
        if(method_exists($this->library, 'getLookUpItems')){
            $this->library->getLookUpItems($page_data);
        }

        foreach ((object)$this->tableName as $table_name) {
            $customFieldLibrary = new \App\Libraries\FieldLibrary();
            $customFields = $customFieldLibrary->getCustomFieldsForTable($table_name);
            $customValues = $customFieldLibrary->getCustomFieldValuesForRecord($numeric_id, $table_name);
            $page_data['customFields'] = $customFields;
            $page_data['customValues'] = $customValues;
            // log_message('error', json_encode($customValues));
        }

        return view($this->session->user_type.'/entity/edit', $page_data);
    }

    function post(){
        $insertId = 0;
        $hashed_hierarchy_id = $this->request->getVar('hierarchy_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' =>'required|min_length[5]|max_length[255]',
                'label' => 'Entity Name',
                'errors' => [
                   'required' => 'Entity Name is required.',
                   'min_length' => 'Entity Name must be at least {value} characters long.',
                   'max_length' => 'Entity Name cannot exceed {value} characters.'
                ]
            ],
            // 'entity_number' => [
            //     'rules' => 'required|min_length[3]|max_length[255]',
            //     'label' => 'Entity Number',
            //     'errors' => [
            //         'required' => 'Entity Number is required.',
            //         'min_length' => 'Entity Number must be at least {value} characters long.',
            //         'max_length' => 'Entity Number cannot exceed {value} characters.',
            //     ]
            // ],
            'parent_id' => [
                'rules' => 'required',
                'label' => 'Parent Entity',
                'errors' => [
                   'required' => 'Parent Entity is required.'
                ]
            ],
            'hierarchy_id' => [
                'rules' => 'required',
                'label' => 'Hierarchy Level',
                'errors' => [
                   'required' => 'Hierarchy Level is required.'
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $hierarchy_id = hash_id($hashed_hierarchy_id, 'decode');
        $parent_id = $this->request->getPost('parent_id');

        $data = [
            'name' => $this->request->getPost('name'),
            'hierarchy_id' => $hierarchy_id,
            'entity_number' => $this->computeEntityNumber($hierarchy_id, $parent_id),//$this->request->getPost('entity_number'),
            'parent_id' => $parent_id,
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
       
        $this->parent_id = $hashed_hierarchy_id;

        if($this->request->isAJAX()){
            $this->feature = 'entity';
            $this->action = 'list';
            $data = $this->model
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy("entities.created_at desc")
            ->where('entities.hierarchy_id', hash_id($hashed_hierarchy_id,'decode'))->findAll();

            $page_data = parent::page_data($data);
            
            return view($this->session->user_type."/entity/list", $page_data);
        }

        return redirect()->to(site_url("denominations/view/".hash_id($insertId)));
    }

    public function update(){

        $hashed_id = $this->request->getVar('id');
        $hashed_hierarchy_id = $this->request->getVar('hierarchy_id');


        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' =>'required|min_length[5]|max_length[255]',
                'label' => 'Entity Name',
                'errors' => [
                   'required' => 'Entity Name is required.',
                   'min_length' => 'Entity Name must be at least {value} characters long.',
                   'max_length' => 'Entity Name cannot exceed {value} characters.'
                ]
            ],
            'entity_number' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'label' => 'Entity Number',
                'errors' => [
                    'required' => 'Entity Number is required.',
                    'min_length' => 'Entity Number must be at least {value} characters long.',
                    'max_length' => 'Entity Number cannot exceed {value} characters.',
                ]
            ],
            'parent_id' => [
                'rules' => 'required',
                'label' => 'Parent Entity',
                'errors' => [
                   'required' => 'Parent Entity is required.'
                ]
            ],
            'hierarchy_id' => [
                'rules' => 'required',
                'label' => 'Hierarchy Level',
                'errors' => [
                   'required' => 'Hierarchy Level is required.'
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }


        $update_data = [
            'name' => $this->request->getPost('name'),
            'hierarchy_id' => hash_id($hashed_hierarchy_id, 'decode'),
            'entity_number' => $this->request->getPost('entity_number'),
            'parent_id' => $this->request->getPost('parent_id'),
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

        $this->parent_id = $hashed_hierarchy_id;

        if($this->request->isAJAX()){
            $this->feature = 'entity';
            $this->action = 'list';
            $records = $this->model
            ->join('entities parent','parent.id=entities.parent_id')
            ->select('entities.id,entities.hierarchy_id,entities.entity_number,entities.name as entity_name,parent.name as parent_name,entities.entity_leader')
            ->orderBy("entities.created_at desc")
            ->where('entities.hierarchy_id', hash_id($hashed_hierarchy_id,'decode'))->findAll();
            
            $page_data = parent::page_data($records);
            // $page_data['parent_id'] = $hashed_hierarchy_id;
            
            return view($this->session->user_type."/entity/list", $page_data);
        }
        
        return redirect()->to(site_url($this->session->user_type."/entities/view/".$hashed_id))->with('message', 'Hierarchy updated successfully!');
    }

    function getParentEntitiesByDenomination($hashed_hierarchy_id, $parent_entity_id){

        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchyLevelObj = $hierarchyModel->where('id',hash_id($hashed_hierarchy_id,'decode'))->first();
        
        $upper_hierarchy_level = 1;
        $denomination_id = 0;

        if($hierarchyLevelObj){
            $upper_hierarchy_level = $hierarchyLevelObj['level'] - 1;
            $denomination_id = $hierarchyLevelObj['denomination_id'];
        }

        $parent_entities = $this->model
        ->where('level', $upper_hierarchy_level)
        ->where('denomination_id', $denomination_id)
        ->join('hierarchies', 'hierarchies.id=entities.hierarchy_id')
        ->select('entities.id,hierarchy_id,entity_number,entities.name,parent_id,entity_leader')
        ->findAll();

        $rst = [];

        if($parent_entities){
            $rst = $parent_entities; 
        }

        return json_encode($rst);
    }

    private function computeEntityNumber($hierarchy_id, $parent_id) {

        $entityNumber = '';
        
        // Get the denomination code for the hierarchy id 
        $hierarchyModel = new \App\Models\HierarchiesModel();
        $hierarchy = $hierarchyModel->select('hierarchies.hierarchy_code,hierarchies.level')
        ->where('hierarchies.id', $hierarchy_id)
        ->first(); 

        $hierarchyCode = $hierarchy['hierarchy_code'];
        $hierarchyLevel = $hierarchy['level'];

        // Count entities in the hierarchy
        $entityCount = $this->model->where('hierarchy_id', $hierarchy_id)->countAllResults();
        ++$entityCount;

         // Pad the entity count to 5 digits with leading zeros
         $entityCount = str_pad($entityCount, 4, '0', STR_PAD_LEFT); 

        if($hierarchyLevel == 2){     
            // Construct the entity number
            $entityNumber = "$hierarchyCode/$entityCount";

            // Check if the constructed entity number already exists in the database
            while($this->model->where('entity_number', $entityNumber)->countAllResults() > 0) {
                ++$entityCount;
                $entityNumber = "$hierarchyCode/$entityCount";
            } 
        }elseif($hierarchyLevel > 2){

            // Get entitynumber of the parent entity
            $parentEntity = $this->model->where('id', $parent_id)->first();
            $parentEntityNumber = $parentEntity['entity_number'];

            $entityNumber = "$parentEntityNumber/$entityCount";

            // Check if the constructed entity number already exists in the database
            while($this->model->where('entity_number', $entityNumber)->countAllResults() > 0) {
                ++$entityCount;
                $entityNumber = "$parentEntityNumber/$entityCount";
            } 
        }
        
        // If the entity number already exists, increment the count and try again

        return $entityNumber;

    }

    public function getDenominationLowestEntities($numeric_denomination_id){
       return  $this->response->setJSON($this->model->getLowestEntities($numeric_denomination_id));
    }

    function getEntitiesByHierarchyId($hierarchy_id){
        $entities = $this->model
        ->where('hierarchy_id', $hierarchy_id)
        ->select('entities.id, entities.name')
        ->orderBy("entity_number asc")
        ->findAll();

        return response()->setJSON($entities);
    }
}
