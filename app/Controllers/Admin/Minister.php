<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;

class Minister extends WebController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\MinistersModel();
        $this->tableName = "ministers";
    }

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
            // 'license_number' => [
            //     'rules' => 'required|min_length[3]|is_unique[ministers.license_number]',
            //     'label' => 'License Number',
            //     'errors' => [
            //        'required' => 'License Number.',
            //        'min_length' => 'License Number must be at least {value} characters long.',
            //     ]
            //  ],
             'member_first_name' => [
                'rules' => 'required|min_length[3]',
                'label' => 'Minister First Name',
                'errors' => [
                   'required' => 'Minister First Name is required.',
                   'min_length' => 'Minister First Name must be at least {value} characters long.',
                ]
            ],
            'member_last_name' => [
                'rules' => 'required|min_length[3]',
                'label' => 'Minister Last Name',
                'errors' => [
                   'required' => 'Minister Last Name is required.',
                   'min_length' => 'Minister Last Name must be at least {value} characters long.',
                ]
            ],
            'assembly_id' => [
                'rules' => 'required',
                'label' => 'Assembly Name',
                'errors' => [
                   'required' => 'Assembly Name is required.'
                ]
            ],
            'designation_id' => [
                'rules' => 'required',
                'label' => 'Designation',
                'errors' => [
                   'required' => 'Designation is required.'
                ]
            ],
            'member_phone' => [
                'rules' => 'required',
                'label' => 'Phone Number',
                'errors' => [
                   'required' => 'Phone Number is required.'
                ]
            ],
            'is_active' => [
                'rules' => 'required',
                'label' => 'Minister Status',
                'errors' => [
                   'required' => 'Minister Status is required.'
                ]
            ]
        ]);


        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        $hashed_minister_id = $this->request->getPost('minister_id');
        $numeric_minister_id = hash_id($hashed_minister_id, 'decode');
        $hashed_member_id = $this->request->getPost('member_id');
        $numeric_member_id = hash_id($hashed_member_id, 'decode');

         // Member Fields
         $member_first_name = $this->request->getPost('member_first_name');
         $member_last_name = $this->request->getPost('member_last_name');
         $assembly_id = $this->request->getPost('assembly_id');
         $designation_id = $this->request->getPost('designation_id');
         $member_phone = $this->request->getPost('member_phone');

        // Minister fields
        $license_number = $this->request->getPost('license_number');
        $is_active = $this->request->getPost('is_active');

        $update_member = [
            'first_name' => $member_first_name,
            'last_name' => $member_last_name,
            'assembly_id' => $assembly_id,
            'designation_id' => $designation_id,
            'phone' => $member_phone,
        ];

        $update_minister = [
            'license_number' => $license_number,
            'is_active' => $is_active,
        ];
        
        $this->model->update($numeric_minister_id, (object)$update_minister);

        $membersModel = new \App\Models\MembersModel();
        $membersModel->update($numeric_member_id, (object)$update_member);

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');

        // Only save custom fields if they are not null
        if (!empty($customFieldValues)) {
            // Filter out null or empty custom fields
            $nonNullCustomFields = array_filter($customFieldValues, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Save non-null custom field values
            if (!empty($nonNullCustomFields)) {
                $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_minister_id,dir: 'decode'), $this->tableName, $customFieldValues);
            }
        }

        $customFieldValuesInDB = $customFieldLibrary->getCustomFieldValuesForRecord(hash_id($hashed_minister_id,dir: 'decode'), 'users');

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
        
        return redirect()->to(site_url($this->session->get('user_type')."/ministers/view/".$hashed_minister_id))->with('message', 'Minister updated successfully!');
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
                'rules' => 'required|min_length[3]|is_unique[ministers.license_number]',
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
