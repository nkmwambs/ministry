<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;


class Assembly extends WebController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\AssembliesModel();
    }

    public function fetchAssemblies()
    {
        $request = \Config\Services::request();

        // Get parameters sent by Datatables
        $draw = intval($request->getPost('draw'));
        $start = intval($request->getPost('start'));
        $length = intval($request->getPost('length'));
        $searchValue = $request->getPost('search')['value'];

        // Get the total number of records
        $totalRecords = $this->model->countAll();

        // Apply search filter if provided
        if (!empty($searchValue)) {
            $this->model->like('name', $searchValue)
                ->orLike('location', $searchValue)
                ->orLike('is_active', $searchValue)
                ->join('entities','entities.id=assemblies.entity_id', 'left');
        }

        // Get the filtered total
        $totalFiltered = $this->model->countAllResults(false);

        // Limit the results and fetch the data
        $this->model->limit($length, $start);
        $data = $this->model->select('assemblies.*,CONCAT(members.first_name, " ", members.last_name) as assembly_leader,entities.name as entity_name')
        ->join('entities','entities.id=assemblies.entity_id', 'left')
        ->join('ministers', 'ministers.id=assemblies.assembly_leader', 'left')
        ->join('members', 'members.id=ministers.member_id', 'left')
        ->find();

        // Loop through the data to apply hash_id()
        foreach ($data as &$assembly) {
            $assembly['hash_id'] = hash_id($assembly['id']);  // Add hashed ID to each record
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

    public function update(){

        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' => 'required|min_length[10]|max_length[255]',
                'label' => 'Assembly Name',
                'errors' => [
                   'required' => 'Assembly Name is required.',
                   'min_length' => 'Assembly Name must be at least {value} characters long.',
                   'max_length' => 'Assembly Name cannot exceed {value} characters.'
                ]
            ],
            'entity_id' => [
                'rules' => 'required|max_length[255]',
                'label' => 'Entity ID',
                'errors' => [
                   'required' => 'Entity ID is required.',
                   'min_length' => 'Entity ID must be at least {value} characters long.',
                ]
            ],
            'location' => [
                'rules' => 'required',
                'label' => 'Location',
                'errors' => [
                   'required' => 'Location is required.'
                ]
            ],
            'is_active' => [
                'rules' => 'required|min_length[2]|max_length[3]',
                'label' => 'Is Active',
                'errors' => [
                   'required' => 'Is Active is required.',
                   'min_length' => 'Is Active must be at least {value} characters long.',
                   'max_length' => 'Is Active cannot exceed {value} characters.'
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();

            return response()->setJSON(['errors' => $validationErrors]);
        }

        $update_data = [
            'name' => $this->request->getPost('name'),
            'planted_at' => $this->request->getPost('planted_at'),
            'location' => $this->request->getPost('location'),
            'entity_id' => $this->request->getPost('entity_id'),
            'assembly_leader' => $this->request->getPost('assembly_leader'),
            'is_active' => $this->request->getPost('is_active'),
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
            $this->feature = 'assembly';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getListData')){
                $records = $this->model->getListData();
            }else{
                $records = $this->model->findAll();
            }
            return view($this->session->get('user_type')."/assembly/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("assembly/view/".$hashed_id))->with('message', 'Assembly updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => [
                'rules' =>'required|min_length[10]|max_length[255]',
                'label' => lang('assembly.assembly_name'),
                'errors' => [
                   'required' => 'The {field} field is required.',
                   'min_length' => 'The {field} field must be at least {param} characters long.',
                   'max_length' => 'The {field} field must not exceed {param} characters long.'
                ]
            ],    
            'entity_id'    => [
                'rules' =>'required|max_length[255]',
                'label' => lang('assembly.assembly_entity_id'),
                'errors' => [
                   'required' => 'The {field} field is required.',
                   'max_length' => 'The {field} field must not exceed {param} characters long.'
                ]
                ],
            'location' => [
                'rules' =>'required',
                'label' => lang('assembly.assembly_location'),
                'errors' => [
                   'required' => 'The {field} field is required.',
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'assembly_code' => $this->computeAssemblyCode($this->request->getPost('entity_id')),
            'planted_at' => $this->request->getPost('planted_at'),
            'location' => $this->request->getPost('location'),
            'entity_id' => $this->request->getPost('entity_id'),
            'assembly_leader' => $this->request->getPost('assembly_leader'),
            'is_active' => 'yes'
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

        if($this->request->isAJAX()){
            $this->feature = 'assembly';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view($this->session->get('user_type')."/assembly/list", parent::page_data($records));
        }

        return redirect()->to(site_url("assemblies/view/".hash_id($insertId)));
    }

    private function computeAssemblyCode($entity_id){

        // Count the number of assembly in an entity
        $assemblyCountNum = $this->model->where('entity_id', $entity_id)->countAllResults() + 1;
        $assemblyCount = str_pad($assemblyCountNum, 4, '0', STR_PAD_LEFT); 

        // Get the entity number
        $entityModel = new \App\Models\EntitiesModel();
        $entity = $entityModel->find($entity_id);
        $entityNumber = $entity['entity_number'];

        // Assembly Code 
        $assembly_code = "$entityNumber/$assemblyCount";

        return $assembly_code;
    }

    function getAssembliesByDenominationId($denomination_id){
        // $denomination_id = $this->request->getGet('denomination_id');
        $records = $this->model->getAssembliesByDenominationId($denomination_id);
        return response()->setJSON($records);
    }
}
