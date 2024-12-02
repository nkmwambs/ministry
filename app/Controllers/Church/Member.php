<?php

namespace App\Controllers\Church;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;

class Member extends WebController
{
    function view($id): string {
        
        $numeric_id = hash_id($id, 'decode');

        $data = [];
        if (method_exists($this->model, 'getViewData')) {
            $data = $this->model->getViewData($numeric_id);
        } else {
            $data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $id;
        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'viewExtraData')) {
            $this->library->viewExtraData($page_data);
        }

        if (
            isset($data) && 
            is_array($data) && 
            array_key_exists('id',$data)
        ) {
            unset($data['id']);
        }

        if ($this->request->isAjax()) {
            return view($this->session->get('user_type') . "/$this->feature/view", $page_data);
        }

        return view('index', compact('page_data'));
    }
    function post(){
        $insertId = 0;
        // $hashed_assembly_id = $this->request->getVar('assembly_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => [
                'rules' =>'required|min_length[3]|max_length[255]',
                'label' => 'First Name',
                'errors' => [
                    'required' => 'First Name is required.',
                    'min_length' => 'First Name must be at least {value} characters long.',
                ]
            ],
            'last_name' => [
                'rules' =>'required|min_length[3]|max_length[255]',
                'label' => 'Last Name',
                'errors' => [
                    'required' => 'Last Name is required.',
                    'min_length' => 'Last Name must be at least {value} characters long.',
                ]
            ],
            'gender' => [
                'rules' =>'required',
                'label' => 'Member.member_gender',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'date_of_birth' => [
                'rules' => 'required',
                'label' => 'Date of Birth',
                'errors' => [
                    'required' => 'Date of Birth is required.',
                ]
            ],
            'phone' => [
                'rules' => 'required|regex_match[/^\+254\d{9}$/]',
                'label' => 'Phone',
                'errors' => [
                    'regex_match' => 'Phone number should be in the format +254XXXXXXXX',
                ]
            ],
            'saved_date' => [
                'rules' => 'required',
                'label' => 'Date Saved',
                'errors' => [
                    'required' => 'Date saved is required.',
                ]
            ]
        ]);

        if (!$this->validate($validation->getRules())) {
            return response()->setJSON(['errors' => $validation->getErrors()]);
        }

        $hashed_assembly_id = $this->request->getPost('assembly_id');
        $assembly_id = hash_id($hashed_assembly_id, 'decode');
        // $parent_id = $this->request->getPost('parent_id');

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'gender' => $this->request->getPost('gender'),
            'assembly_id' => $assembly_id,
            'member_number' => $this->computeMemberNumber($assembly_id),
            'designation_id' => $this->request->getPost('designation_id'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'email' => $this->request->getPost('email'),
            'saved_date' => $this->request->getPost('saved_date'),
            'membership_date' => $this->request->getPost('membership_date'),

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
                $customFieldLibrary->saveCustomFieldValues($insertId, $this->tableName, $customFieldValues);
            }
        }

        
        // $this->parent_id = $hashed_assembly_id;
        $this->action = "view";
        $this->feature = "assembly";
        $this->id = $hashed_assembly_id;
        $page_data = parent::page_data();

        return redirect()->to(site_url("church/assemblies/view/$hashed_assembly_id"));

    }
    private function computeMemberNumber($assembly_id) {
        $memberNumber = '';

        $entityModel = new \App\Models\EntitiesModel();
        $assemblyEntity = $entityModel->select('entities.entity_number,assemblies.name')
        ->join('assemblies', 'assemblies.entity_id = entities.id')
        ->where('assemblies.id', $assembly_id)->first();

        $assemblyEntityNumber = $assemblyEntity['entity_number'];
        // $maxEntityNumber = $this->model->selectMax('member_number')->where('assembly_id', $entity_id)->first();

        $memberCount = $this->model->where('assembly_id',$assembly_id)->countAllResults();
        ++$memberCount;
        $memberCount = str_pad($memberCount,4,'0',STR_PAD_LEFT);

        // $parentMember = $this->model->where('id', $entity_id)->first();
        // $parentMemberNumber = $parentMember['member_number'];

        $memberNumber = "$assemblyEntityNumber/ME/$memberCount";

        // while ($this->model->where('member_number', $memberNumber)->countAllResults() > 0) {
            // ++$memberCount;
            // $memberNumber = "$parentMemberNumber/$memberCount";
        // }

        return $memberNumber;
    }
    public function add($parent_id = null): string
    {
        $page_data = $this->page_data();
        $page_data['parent_id'] = $parent_id;

        if (method_exists($this->library, 'addExtraData')) {
            // Note the addExtraData updates the $page_data by reference
            $this->library->addExtraData($page_data);
        }

        foreach ((object) $this->tableName as $table_name) {
            $customFieldLibrary = new \App\Libraries\FieldLibrary();
            $customFields = $customFieldLibrary->getCustomFieldsForTable($table_name);
            $page_data['customFields'] = $customFields;
        }

        return view('index', compact('page_data'));
    }

    

}
