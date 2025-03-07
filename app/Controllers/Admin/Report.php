<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use \CodeIgniter\HTTP\ResponseInterface;

class Report extends WebController
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
                ->join('denominations', 'denominations.id = reporttypes.denomination_id', 'LEFT')
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
        ->join('denominations', 'denominations.id = reporttypes.denomination_id', 'LEFT')
        ->where('reports.reports_type_id', $numericReportTypeId)
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
            // 'denomination_id' => $this->request->getPost('denomination_id'),
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
            return view($this->session->get('user_type')."/report/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url($this->session->get('user_type')."/reports/view/".$hashed_id))->with('message', 'Report updated successfully!');
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
            // 'denomination_id' => $this->request->getPost('denomination_id'),
            'assembly_id' => $this->request->getPost('assembly_id'),
            'reports_type_id' => hash_id($this->request->getPost('reports_type_id'),'decode'),
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
            return view($this->session->get('user_type')."/report/list", parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type')."/report/view/".hash_id($insertId)))->with('message', 'Report added seccessfuly!');;
    }

    function list($hashedReportTypeId){
        $this->feature = 'report';
        $this->action = 'list';
        // $reportsByTypeId = [];

        // Get Reports by ReportTypeId 
        $reportsByTypeId = $this->model->where('reports_type_id', hash_id($hashedReportTypeId, 'decode'))->findAll();

        $this->parent_id = $hashedReportTypeId;
        $page_data = parent::page_data($reportsByTypeId);

        return view("index", compact('page_data'));
    }

    function getReportLayout($report_id){
        $reportsModel = new \App\Models\ReportsModel();
        $reportsModel->select('reporttypes.report_layout,reporttypes.name as report_type_name,denominations.code as denomination_code');
        $reportsModel->join('reporttypes','reports.reports_type_id=reporttypes.id');
        $reportsModel->join('assemblies','reports.assembly_id=assemblies.id');
        $reportsModel->join('entities','assemblies.entity_id=entities.id');
        $reportsModel->join('hierarchies','entities.hierarchy_id=hierarchies.id');
        $reportsModel->join('denominations','hierarchies.denomination_id=denominations.id');
        $reportLayout = $reportsModel->find($report_id);

        return $reportLayout;
    }

    function completeTransaction(){
        $post = $this->request->getPost();
        $hashed_report_id = array_shift($post);
        $report_id = hash_id($hashed_report_id,'decode');

        // Get report type by report_id
        $reportLayout = $this->getReportLayout($report_id);

        $mpesa = new \App\Libraries\MpesaLibrary();
        $post['remitted_amount'] = 1;
        $mpesaPayment = $mpesa->express($reportLayout['denomination_code'], $reportLayout['report_type_name'], $post['paying_number'], $post['remitted_amount']);
        
        // log_message('error', json_encode($reportLayout));
        // log_message('error', $mpesaPayment);

        $stkResponse = json_decode($mpesaPayment);

        // {
        //     "requestId":"fe1e-4199-8a60-70ebcbfc601826622175",
        //     "errorCode": "400.002.02",
        //     "errorMessage": "Bad Request - Invalid PhoneNumber"
        // }


        // {    
        //     "MerchantRequestID": "29115-34620561-1",    
        //     "CheckoutRequestID": "ws_CO_191220191020363925",    
        //     "ResponseCode": "0",    
        //     "ResponseDescription": "Success. Request accepted for processing",    
        //     "CustomerMessage": "Success. Request accepted for processing"
        //  }
        
        $responseCode = (array)$stkResponse;
        
        if(isset($responseCode['ResponseCode']) && $stkResponse->ResponseCode == 0){
            $transactionsModel = new \App\Models\TransactionsModel();

            $stkDataToInsert = [
                'merchant_request' => $stkResponse->MerchantRequestID,
                'checkout_request' => $stkResponse->CheckoutRequestID,
                'response_code' => $stkResponse->ResponseCode,
                'response_description' => $stkResponse->ResponseDescription,
                'customer_message' => $stkResponse->CustomerMessage,
                'record_id' => $report_id,
                'feature_id' => 18,
            ];

            $transactionsModel->insert($stkDataToInsert);


            return response()->setJSON(['complete' => 'Payment successful']);
        }else{
            return response()->setJSON(['error' => ['Payment failed']]);
        }

    }

    function saveReport(){
        $post = $this->request->getPost();
        $hashed_report_id = array_shift($post);
        $report_id = hash_id($hashed_report_id,'decode');

        $mandatory_fields = ['paying_number', 'remitted_amount','church_treasurer_name','church_treasurer_phone','pastor_telephone_no','name_of_pastor'];
        
        $paying_number = $post['paying_number'];
        $remitted_amount = $post['remitted_amount'];
        $church_treasurer_name = $post['church_treasurer_name'];
        $church_treasurer_phone = $post['church_treasurer_phone'];
        $pastor_telephone_no = $post['pastor_telephone_no'];
        $name_of_pastor = $post['name_of_pastor'];

        // Define validation rules
        $data = [
            'paying_number'    => $paying_number == "" ? $church_treasurer_phone: $paying_number,
            'remitted_amount' => $remitted_amount,
            'church_treasurer_name' => $church_treasurer_name,
            'church_treasurer_phone' => $church_treasurer_phone,
            'pastor_telephone_no' => $pastor_telephone_no,
            'name_of_pastor' => $name_of_pastor,
        ];

        $rules = [
            'paying_number' => [
                'rules' =>'required|min_length[10]|max_length[13]',
                'label' => 'Paying Phone Number',
                'errors' => [
                    'required' => 'Paying phone number is required.',
                    'min_length' => 'Paying phone number must be at least {value} characters long.',
                ]
            ],
            'remitted_amount' => [
                'rules' =>'required',
                'label' => 'Remitted Amount',
                'errors' => [
                    'required' => 'Remitted amount is required. Please enter the paying phone number to compute the amount',
                ]
            ],
            'church_treasurer_name' => [
                'rules' =>'required',
                'label' => 'Treasurer Name',
                'errors' => [
                    'required' => 'Treasurer name is required.',
                ]
            ],
            'church_treasurer_phone' => [
                'rules' => 'required|min_length[10]|max_length[13]',
                'label' => 'Treasurer Number',
                'errors' => [
                    'required' => 'Paying number must be at least {value} characters long.',
                ]
            ],
            'name_of_pastor' => [
                'rules' =>'required',
                'label' => 'Pastor Name',
                'errors' => [
                    'required' => 'Pastor name is required.',
                ]
            ],
            'pastor_telephone_no' => [
                'rules' => 'required|min_length[10]|max_length[13]',
                'label' => 'Pastor Phone Number',
                'errors' => [
                    'required' => 'Pastor phone number must be at least {value} characters long.',
                ]
            ]
        ];

        if (!$this->validateData($data, $rules)) {
            return $this->response->setJSON(['errors' => $this->validator->getErrors()]); // 
        }else{
            // Get report type by report_id
            $reportLayout = $this->getReportLayout($report_id);

            unset($post['paying_number']);
            unset($post['remitted_amount']);

            $reportLayoutArray = json_decode($reportLayout['report_layout']);
            $section_parts = array_column($reportLayoutArray, 'section_parts');

            $fieldIds = [];
            foreach($section_parts as $section_part){
                foreach($section_part as $part){
                    $fieldIds = array_merge($fieldIds, explode(",",$part->part_fields[0]));
                }
            }

            // Get all reports template fields
            $fieldsModel = new \App\Models\FieldsModel();
            $fieldsModel->select('id as customfields_id,field_name,field_code');
            $reportsFields = $fieldsModel->whereIn('id',$fieldIds)->findAll();

            $fieldCodeKeyedFields = [];
            foreach($reportsFields as $reportsField){
                $fieldCodeKeyedFields[$reportsField['field_code']] = $reportsField;
            }

            // Delete saved records if exists
            $reportDetailsModel = new \App\Models\SavedReportsModel();
            $reportDetailsModel->where('report_id', $report_id)->delete();

            foreach($post as $postKey => $postValue){
                if(array_key_exists($postKey, $fieldCodeKeyedFields)){
                    $fieldId = $fieldCodeKeyedFields[$postKey]['customfields_id'];
                    $fieldCode = $fieldCodeKeyedFields[$postKey]['field_code'];
                    $fieldValue = $postValue;

                    $reportDetailsModel->insert([
                        'report_id' => $report_id,
                        'customfields_id' => $fieldId,
                        'field_code' => $fieldCode,
                        'report_value' => $fieldValue,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => session()->get('user_id'),
                    ]);
                }
            }
            
            $reportLibrary = new \App\Libraries\ReportLibrary();
            $reportLibrary->convertCustomNamedFieldsToIds($post);
            
            $values = json_encode($post);
            
            // Connect to database 
            $model = new \App\Models\DetailsModel();
            $model->upsert((object)compact('report_id', 'values'));

            return $this->response->setJSON(['success' => 'You have received a prompt in your phone with number '.$paying_number.' .Enter the amount Kes. '.number_format($remitted_amount,2).' to complete the transaction.']);
        }
    }
}
