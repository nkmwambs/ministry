<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorsModel extends Model
{
    protected $table            = 'visitors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','first_name','last_name','phone','email','gender','date_of_birth','event_id','payment_id','payment_code','registration_amount','status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['updateRecycleBin'];

    public function getAll(){
        $library = new \App\Libraries\VisitorLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())->orderBy('created_at desc')->findAll();
        }else{
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\VisitorLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($visitor_id){
        $library = new \App\Libraries\VisitorLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                // ->join('denominations', 'denominations.id = visitors.denomination_id')
                ->where('visitors.id', $visitor_id)
                ->first();
        } else {
            return $this->where('id', $visitor_id)->first();
        }
    }

    public function getViewData($visitor_id){
        $library = new \App\Libraries\VisitorLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                // ->join('denominations', 'denominations.id = visitors.denomination_id')
                ->where('visitors.id', $visitor_id)
                ->first();
        } else {
            return $this->where('id', $visitor_id)->first();
        }
    }

    public function getVisitorsByEventId($event_id)
    {
        return $this->where('event_id', $event_id)->findAll();
    }

    function updateRecycleBin($data){

        $trashModel = new \App\Models\TrashesModel();
        $trashData = [
            'item_id' => $data['id'][0],
            'item_deleted_at' => date('Y-m-d H:i:s')
        ];
        $trashModel->insert((object)$trashData);
        return true;
    }
}
