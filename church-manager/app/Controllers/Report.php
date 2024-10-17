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
    
    public function fetchReports()
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
            $this->model->like('report_period', $searchValue)
                ->orLike('report_type_id', $searchValue)    
                ->orLike('report_date', $searchValue)
                ->orLike('status', $searchValue)
                ->join('reporttypes', 'reporttypes.id = reports.reports_type_id','LEFT')
                ->join('assemblies', 'assemblies.id = reports.assembly_id','LEFT')
                ->join('denominations', 'denominations.id = reports.denomination_id', 'LEFT')
                ->countAllResults();
        }

        // Get the filtered total
        $totalFiltered = $this->model->countAllResults(false);

        $numericReportTypeId = hash_id($this->request->getPost('reportTypeId'),'decode');
        // Limit the results and fetch the data
        $this->model->limit($length, $start);
        $data = $this->model->select('reports.*,assemblies.name as assembly_name,reporttypes.name as reporttype_name,denominations.name as denomination_name')
        ->join('reporttypes', 'reporttypes.id = reports.reports_type_id','LEFT')
        ->join('assemblies', 'assemblies.id = reports.assembly_id','LEFT')
        ->join('denominations', 'denominations.id = reports.denomination_id', 'LEFT')
        ->find();

        // Loop through the data to apply hash_id()
        foreach ($data as &$report) {
            $report['hash_id'] = hash_id($report['id']);  // Add hashed ID to each record
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
            'report_period' => 'required',
            'report_date' => 'required',
            // 'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $update_data = [
            'denomination_id' => $this->request->getPost('denomination_id'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'reports_type_id' => $this->request->getPost('reports_type_id'),
            'report_period' => $this->request->getPost('report_period'),
            'report_date' => $this->request->getPost('report_date'),
            // 'status' => 'approved',
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
            // 'status' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $data = [
            'denomination_id' => $this->request->getPost('denomination_id'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'reports_type_id' => $this->request->getPost('reports_type_id'),
            'report_period' => $this->request->getPost('report_period'),
            'report_date' => $this->request->getPost('report_date'),
            // 'status' => $this->request->getPost('status'),
        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');
        $customFieldLibrary->saveCustomFieldValues($insertId, $this->tableName, $customFieldValues);

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

    function list($hashedReportTypeId){
        $this->feature = 'report';
        $this->action = 'list';
        // $reportsByTypeId = [];

        // Get Reports by ReportTypeId 
        $reportsByTypeId = $this->model
        ->select('reports.*,assemblies.name as assembly_name,reporttypes.name as reporttype_name,denominations.name as denomination_name')
        ->join('reporttypes', 'reporttypes.id = reports.reports_type_id','LEFT')
        ->join('assemblies', 'assemblies.id = reports.assembly_id','LEFT')
        ->join('denominations', 'denominations.id = reports.denomination_id', 'LEFT')
        ->where('reports_type_id', hash_id($hashedReportTypeId, 'decode'))->findAll();

        $page_data = parent::page_data($reportsByTypeId);

        // log_message('error', json_encode($page_data));

        return view("index", compact('page_data'));
    }

    //  public function section_a()
    //  {
    //     //  $data['result'] = $this->reportModel->getSectionAData();
    //     return view('report/section/view_a');
    //  }
 
    //  public function section_b()
    //  {
    //     //  $data['result'] = $this->reportModel->getSectionBData();
    //      return view('report/section/view_b');
    //  }
}
