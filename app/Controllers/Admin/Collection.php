<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;

use \CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

class Collection extends WebController
{
    protected $model = null;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\CollectionsModel();
        $this->library = new \App\Libraries\CollectionLibrary();
    }

    function post(){
        $insertId = 0;
        $data = $this->request->getPost();
    
        $assembly_id = $this->request->getPost('assembly_id');
        $return_date = $this->request->getPost('sunday_date');
        $sunday_count = getSundayNumberInMonth($return_date);
        $revenue_ids = $this->request->getPost('revenue_id');
        $amounts = $this->request->getPost('amount');

        $data['sunday_count'] = $sunday_count;
        if (!$this->validateData($data,"addCollection")) {
            return response()->setJSON(['errors' => $this->validator->getErrors()]);
        }

        foreach($revenue_ids as $key => $revenue_id){
            $data = [
                'return_date' => $return_date,
                'revenue_id' => $revenue_id,
                'assembly_id' => $assembly_id,
                'amount' => $amounts[$key],
                'sunday_count' => $sunday_count,
            ];

            $this->model->insert((object)$data);
        }

        $this->parent_id = hash_id($assembly_id,'encode');

        if($this->request->isAJAX()){
            $this->feature = 'collection';
            $this->action = 'list';
            $records = [];

            if(method_exists($this->model, 'getAll')){
                $records = $this->model->getAll();
            }else{
                $records = $this->model->findAll();
            }
            return view($this->session->get('user_type')."/collection/list", parent::page_data($records));
        }

        return redirect()->to(site_url($this->session->get('user_type')."/collections/view/".hash_id($insertId)));
    }

    public function update(){

        $validation = \Config\Services::validation();
        $validation->setRules([
            'return_date' => 'required',
            'revenue_id' => 'required',
            'amount' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            $validationErrors = $validation->getErrors();
            return response()->setJSON(['errors' => $validationErrors]);
        }

        // if(method_exists($this->library, 'customEditValidation')){
        //     $this->library->customEditValidation();
        // }
        
        $hashed_id = $this->request->getVar('id');
        // $hashed_assembly_id = $this->request->getVar('assembly_id');
        $return_date = $this->request->getPost('return_date');

        $update_data = [
            'return_date' => $return_date,
            'revenue_id' => $this->request->getPost('revenue_id'),
            'amount' => $this->request->getPost('amount'),
            'sunday_count' => getSundayNumberInMonth($return_date)
        ];
        
        $this->model->update(hash_id($hashed_id,'decode'), (object)$update_data);

        if($this->request->isAJAX()){
            $this->feature = 'collection';
            $this->action = 'list';

            $records = $this->model->select('collections.id,return_date,sunday_count,period_start_date,period_end_date,assembly_id,assemblies.name as assembly_name,revenue_id,revenues.name as revenue_name,collections.amount,collections.status,collection_reference,collections.description,collection_method')
            ->join('assemblies', 'assemblies.id = collections.assembly_id')
            ->join('revenues', 'revenues.id = collections.revenue_id')
            ->orderBy("collections.return_date desc")
            // ->where('assembly_id', hash_id($hashed_assembly_id, 'decode'))
            ->findAll();

            return view($this->session->get('user_type')."/collection/list", parent::page_data($records));
        }
        
        return redirect()->to(site_url($this->session->get('user_type')."/collection/view/".$hashed_id))->with('message', 'Collection updated successfully!');
    }

    // private function computeNextHierarchicalLevel($denomination_id){
    //     $maxLevel = $this->model->selectMax('level')->where('denomination_id', $denomination_id)->first();
    //     return $maxLevel['level'] + 1;
    // }
}
