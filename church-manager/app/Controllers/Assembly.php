<?php

namespace App\Controllers;

class Assembly extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\AssembliesModel();
    }

    public function fetchAssemblies() {

        $request =\Config\Services::request();

        //get parameters sent by Datatables
        $draw = intval($request->getPost('draw'));
        $start = intval($request->getPost('start'));
        $length = intval($request->getPost('length'));
        $searchValue = $request->getPost('search')['value'];

        $totalRecords = $this->model->countAll();

        if (!empty($searchValue)) {
            $this->model->like('name', $searchValue)
                        ->orLike('location', $searchValue)
                        ->orLike('email', $searchValue);
        }

        $totalFiltered = $this->model->countAllResults(false);


        $this->model->limit($length, $start);
        $data = $this->model->find();

        // Prepare response data for DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $data,
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

        if($this->request->isAJAX()){
            $this->feature = 'assembly';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getListData')){
                $records = $this->model->getListData();
            }else{
                $records = $this->model->findAll();
            }
            return view("assembly/list", parent::page_data($records));
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
            'planted_at' => $this->request->getPost('planted_at'),
            'location' => $this->request->getPost('location'),
            'entity_id' => $this->request->getPost('entity_id'),
            'assembly_leader' => $this->request->getPost('assembly_leader'),
            'is_active' => 'yes'
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'assembly';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("assembly/list", parent::page_data($records));
        }

        return redirect()->to(site_url("assemblies/view/".hash_id($insertId)));
    }

    function getAssembliesByDenominationId($denomination_id){
        // $denomination_id = $this->request->getGet('denomination_id');
        $records = $this->model->getAssembliesByDenominationId($denomination_id);
        return response()->setJSON($records);
    }
}
