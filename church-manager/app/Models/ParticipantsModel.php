<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantsModel extends Model
{
    protected $table            = 'participants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','member_id','event_id','payment_id','registration_amount','status'];

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
    protected $afterDelete    = [];

    public function getAll(){
        $library = new \App\Libraries\ParticipantLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())->orderBy('participants.created_at desc')
            ->join('members', 'members.id=participants.member_id')
            ->join('events', 'events.id=participants.event_id')
            ->join('payments','payments.id=participants.payment_id')
            ->findAll();
        }else{
            return $this->orderBy('participants.created_at desc')
            ->join('members', 'members.id=participants.member_id')
            ->join('events', 'events.id=participants.event_id')
            ->join('payments','payments.id=participants.payment_id')
            ->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\ParticipantLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($participant_id){
        $library = new \App\Libraries\ParticipantLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('events', 'events.id = participants.event_id')
                ->where('participants.id', $participant_id)
                ->first();
        } else {
            return $this->where('id', $participant_id)->first();
        }
    }

    public function getViewData($participant_id){
        $library = new \App\Libraries\ParticipantLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('events', 'events.id = participants.event_id')
                ->where('participants.id', $participant_id)
                ->first();
        } else {
            return $this->where('id', $participant_id)->first();
        }
    }

    public function getParticipantsByEventId($event_id)
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
