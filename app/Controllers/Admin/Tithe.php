<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Tithe extends WebController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\TithesModel();
    }

    function post(){
        $insertId = 0;

        $data = $this->request->getPost();

        if (!$this->validateData($data, 'addTithe')) {
            return response()->setJSON(['errors' => $this->validator->getErrors()]);
        }

        // $hashed_assembly_id = $this->request->getPost('assembly_id');
        $assembly_id = $this->request->getPost('assembly_id');
        $tithing_date = $this->request->getPost('tithing_date');
        $member_ids = $this->request->getPost('member_id');
        $amounts = $this->request->getPost('amount');

        foreach($member_ids as $key => $member_id){
            $data = [
               'member_id' => $member_id,
                'amount' => $amounts[$key],
                'assembly_id' => $assembly_id,
                'tithing_date' => $tithing_date,
            ];

            $this->model->insert((object)$data);
        }

        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFieldValues = $this->request->getPost('custom_fields');

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

        if($this->request->isAJAX()){
            $this->feature = 'tithe';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view($this->session->get('user_type')."/tithe/list", parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type')."/tithes/view/".hash_id($insertId)));
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'member_id' => [
                'rules' =>'required',
                'label' => 'Member Name',
                'errors' => [
                    'required' => 'First Name is required.',
                ]
            ],
            'amount' => [
                'rules' =>'required',
                'label' => 'Tithe Amount',
                'errors' => [
                    'required' => 'Tithe Amount is required.',
                ]
            ],
        ]);

        if (!$this->validate($validation->getRules())) {
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }
        
        $hashed_id = $this->request->getVar('id');
        $hashed_assembly_id = $this->request->getVar('assembly_id');

        $update_data = [
            'member_id' => $this->request->getPost('member_id'),
            'amount' => $this->request->getPost('amount'),
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

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
                $customFieldLibrary->saveCustomFieldValues(hash_id($hashed_id,dir: 'decode'), $this->tableName, $customFieldValues);
            }
        }

        $customFieldValuesInDB = $customFieldLibrary->getCustomFieldValuesForRecord(hash_id($hashed_id,dir: 'decode'), 'users');

        if($this->request->isAJAX()){
            $this->feature = 'tithe';
            $this->action = 'list';

            $records = $this->model
            ->select('tithes.id,tithing_date,tithes.member_id,members.assembly_id as assembly_id,tithes.amount,members.first_name as member_first_name,members.last_name as member_last_name')
            ->join('members','members.id = tithes.member_id')
            ->join('assemblies','assemblies.id=members.assembly_id')
            ->orderBy("tithes.created_at desc")
            ->where('assembly_id', hash_id($hashed_assembly_id,'decode'))
            ->findAll();
            return view($this->session->get('user_type')."/tithe/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url($this->session->get('user_type')."/tithe/view/".$hashed_id))->with('message', 'Tithe updated successfully!');
    }
}
