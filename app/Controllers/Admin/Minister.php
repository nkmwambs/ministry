<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;

class Minister extends WebController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\MinistersModel();
    }

    // public function index($parent_id = ''): string
    // {

    //     if(!auth()->user()->canDo("$this->feature.read")){
    //         $page_data = $this->page_data(['errors' =>  []]);

    //         if ($this->request->isAJAX()) {
    //             return view("errors/html/error_403", $page_data);
    //         }

    //         return view('index', compact('page_data'));
    //     }

        
    //     $ministers = [];

    //     if($parent_id > 0){
    //         $ministers = $this->model->select('ministers.id as minister_id,ministers.is_active,members.id as member_id,members.first_name,members.last_name,members.gender,members.last_name,assembly_id,assemblies.name as assembly_name,member_number,designations.name as designation_name,designation_id,members.date_of_birth,members.email,members.phone,associated_member_id as member_is_user')
    //         ->where('denomination_id',hash_id($parent_id,'decode') )
    //         ->join('assemblies','assemblies.id=members.assembly_id','left')
    //         ->join('users','users.associated_member_id = members.id','left')
    //         ->join('designations','designations.id = members.designation_id')
    //         ->join('ministers','ministers.member_id = members.id')
    //         ->orderBy('ministers.created_at desc')
    //         ->findAll();
    //     }else{
    //         // $members = $this->model->select('members.id,members.first_name,members.gender,members.last_name,assembly_id,member_number,designations.name as designation_name,designation_id,members.date_of_birth,members.email,members.phone,associated_member_id as member_is_user')
    //         $ministers = $this->model->select('ministers.id as minister_id,ministers.is_active,members.id as member_id,members.first_name,members.last_name,members.gender,members.last_name,assembly_id,assemblies.name as assembly_name,member_number,designations.name as designation_name,designation_id,members.date_of_birth,members.email,members.phone,associated_member_id as member_is_user')
    //         ->join('assemblies','assemblies.id=members.assembly_id','left')
    //         ->join('users','users.associated_member_id = members.id','left')
    //         ->join('designations','designations.id = members.designation_id')
    //         ->join('ministers','ministers.member_id = members.id')
    //         ->orderBy('members.created_at desc')
    //         ->findAll();
    //     }
       
    //     if(!$ministers){
    //         $page_data['result'] = [];
    //     }else{
    //         $page_data['result'] = $ministers;
    //     }

    //     $page_data['result'] = $ministers;
    //     $page_data['feature'] = 'member';
    //     $page_data['action'] = 'list';
        
    //     if ($this->request->isAJAX()) {
    //         $page_data['parent_id'] = $parent_id;
    //         return view($this->session->get('user_type').'/minister/list', $page_data);
    //     }else{

    //         $data = [];

    //         if (method_exists($this->model, 'getListData')) {
    //             $data = $this->model->getListData();
    //         } else {
    //             method_exists($this->model, 'getAll') ?
    //                 $data = $this->model->getAll() :
    //                 $data = $this->model->findAll();
    //         }
    //         // $page_data['content'] = view($this->feature.DS.$this->action, $page_data);
    //         $page_data = $this->page_data($data);

    //         if (method_exists($this->library, 'listExtraData')) {
    //             // Note the editExtraData updates the $page_data by reference
    //             $this->library->listExtraData($page_data);
    //         }
    //     }

    //     return view('index', compact('page_data'));
    // }

    public function fetchMinisters()
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
                ->orLike('phone', $searchValue)
                ->orLike('is_active', $searchValue);
        }

        // Get the filtered total
        $totalFiltered = $this->model->countAllResults(false);

        $library = new \App\Libraries\MinisterLibrary();
        $listQueryFields = $library->setListQueryFields();

        // Limit the results and fetch the data
        $data = $this->model->limit($length, $start)
            ->select($listQueryFields)
            ->join('members','members.id=ministers.member_id')
            ->join('assemblies','assemblies.id=members.assembly_id','left')
            ->join('users','users.associated_member_id = members.id','left')
            ->join('designations','designations.id = members.designation_id')
            ->orderBy('ministers.created_at desc')
            ->find();

        // Loop through the data to apply hash_id()
        foreach ($data as &$minister) {
            $minister['hash_id'] = hash_id($minister['id']);  // Add hashed ID to each record
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
            // 'name' => 'required|min_length[10]|max_length[255]',
            // 'minister_number' => 'required|min_length[3]',
            'member_id' => 'required',
            'is_active' => 'required|min_length[2]|max_length[3]',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $update_data = [
            'member_id' => $this->request->getPost('member_id'),
            'is_active' => $this->request->getPost('is_active'),
            // 'updated_at' => date('Y-m-d H:i:s')  // Uncomment this line if you want to update 'updated_at' field as well.
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
            $this->feature = 'minister';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view($this->session->get('user_type')."/minister/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url($this->session->get('user_type')."/ministers/view/".$hashed_id))->with('message', 'Minister updated successfully!');
    }

    function post(){
        $insertId = 0;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'member_id' => [
                'rules' => 'required',
                'label' => 'Member Name',
                'errors' => [
                    'required' => 'Member name is required.',
                    ]
                ],
                'license_number' => [
                'rules' => 'required',
                'label' => 'License Number',
                'errors' => [
                    'required' => 'License number is required.',
                ]
            ],
            'assembly_id' => [
                'rules' => 'required',
                'label' => 'Assembly Name',
                'errors' => [
                    'required' => 'Assembly is required.',
                ]
            ]
        ]);
    
        if (!$this->validate($validation->getRules())) {
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        
        $member_id = $this->request->getPost('member_id');

        $data = [
            'minister_number' => $this->computeMinisterNumber($member_id),
            'member_id' => $member_id,
            'license_number' => $this->request->getPost('license_number'),        ];

        $this->model->insert((object)$data);
        $insertId = $this->model->getInsertID();


        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');

        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                $customFieldLibrary->saveCustomFieldValues($insertId, 'ministers', $customFieldValues);
            }
        }

        if($this->request->isAJAX()){
            $this->feature = 'minister';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view($this->session->get('user_type')."/minister/list", parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type')."/ministers/view/".hash_id($insertId)))->with('message', 'Minister added seccessfuly!');;
    }

    private function computeMinisterNumber($member_id) {

        // Member model
        $membersModel = new \App\Models\MembersModel();
        $member = $membersModel->select('denominations.code as denomination_code')
        ->join('assemblies','assemblies.id=members.assembly_id')
        ->join('entities','entities.id=assemblies.entity_id')
        ->join('hierarchies','hierarchies.id=entities.hierarchy_id')
        ->join('denominations','denominations.id=hierarchies.denomination_id')
        ->where('members.id', $member_id)
        ->first();

        $ministerCount = $this->model->countAllResults();
        ++$ministerCount;

        $ministerCount = str_pad($ministerCount,4,'0',STR_PAD_LEFT);

        $ministerNumber = $member['denomination_code']."/MS/$ministerCount";

        while ($this->model->where('minister_number', $ministerNumber)->countAllResults() > 0) {
            ++$ministerCount;
            $ministerNumber = "MIN/$ministerCount";
        }

        return $ministerNumber;
    }
}
