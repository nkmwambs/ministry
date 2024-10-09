<?php

namespace App\Controllers;

use \CodeIgniter\HTTP\ResponseInterface;

class Report extends BaseController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\ReportsModel();
    }    

    public function view($hashed_id): string {
        $data = [];
        $numeric_id = hash_id($hashed_id,'decode');
        
        if(method_exists($this->model, 'getViewData')){
            $data = $this->model->getViewData($numeric_id);
        }else{
            $data = $this->model->getOne($numeric_id);
        }

        $page_data = $this->page_data($data);
        if(method_exists($this->library,'viewExtraData')){  
            // Note the editExtraData updates the $page_data by reference
            $this->library->viewExtraData($page_data);
        }

        // if(array_key_exists('id',$data)){
        if (isset($data) && is_array($data) && array_key_exists('id', $data)) {
            unset($data['id']);
        }

        if($this->request->isAJAX()){
            return view("$this->feature/view", $page_data);
        }

        return view('index', $this->page_data($data));
    }

    public function editReport(): string {
        $data = [];
        $numeric_id = hash_id($this->id,'decode');

        if(method_exists($this->model, 'getEditData')){
            $data = $this->model->getEditData($numeric_id);
        }else{
            $data = $this->model->getOne($numeric_id);
        }

        $page_data = $this->page_data($data);
        
        if(method_exists($this->library,'editExtraData')){
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }

        foreach ((object)$this->tableName as $table_name) {
            $customFieldLibrary = new \App\Libraries\FieldLibrary();
            $customFields = $customFieldLibrary->getCustomFieldsForTable($table_name);
            $customValues = $customFieldLibrary->getCustomFieldValuesForRecord($numeric_id, $table_name);
            $page_data['customFields'] = $customFields;
            $page_data['customValues'] = $customValues;
        }

        return view("report/edit", $page_data);
    }



    public function update(){

        $hashed_id = $this->request->getVar('id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'report_period' => 'required',
            'report_date' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $update_data = [
            'reports_type_id' => $this->request->getPost('reports_type_id'),
            'report_period' => $this->request->getPost('report_period'),
            'report_date' => $this->request->getPost('report_date'),
            'status' => 'approved',
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,'decode'), $this->tableName, $customFieldValues);

        if($this->request->isAJAX()){
            $this->feature = 'report';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("report/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url("reports/view/".$hashed_id))->with('message', 'Report updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'report_period' => 'required',
            'report_date' => 'required',
            'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        // $customFieldLibrary = new \App\Libraries\FieldLibrary();
        // $customFieldValues = $this->request->getPost('custom_fields');
        // $customFieldLibrary->saveCustomFieldValues($insertId, $this->tableName, $customFieldValues);

        $data = [
            'reports_type_id' => $this->request->getPost('reports_type_id'),
            'report_period' => $this->request->getPost('report_period'),
            'report_date' => $this->request->getPost('report_date'),
            'status' => $this->request->getPost('status'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        if($this->request->isAJAX()){
            $this->feature = 'report';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view("report/list", parent::page_data($records));
        }

        return redirect()->to(site_url("report/view/".hash_id($insertId)))->with('message', 'Report added seccessfuly!');;
    }

    public function load_section($section)
    {
        // Construct the section view path
        $viewPath = 'field/section/' . $section;

        // Check if the view exists
        if (file_exists(APPPATH . 'Views/' . $viewPath . '.php')) {
            return view($viewPath); // Return the section view
        } else {
            return '<div class="error">Section not found.</div>'; // Error if view doesn't exist
        }
    }

     // Load Section A view
     public function section_a()
     {
         // Fetch data for Section A if needed
        //  $data['result'] = $this->reportModel->getSectionAData();
         
         // Return the Section A view
         return view('report/section/view_a');
     }
 
     // Similarly, add a method for Section B, etc.
     public function section_b()
     {
        //  $data['result'] = $this->reportModel->getSectionBData();
         return view('report/section/view_b');
     }
}
