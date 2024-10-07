<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Event::class; //'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','meeting_id','start_date','code','end_date','location','description','denomination_id','registration_fees'];

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
        $library = new \App\Libraries\EventLibrary();
        $listQueryFields = $library->setListQueryFields();

        if (!empty($listQueryFields)) {
            return $this->select($library->setListQueryFields())
            ->join('denominations', 'denominations.id = events.denomination_id')
            ->join('meetings', 'meetings.id = events.meeting_id')
            ->findAll();
        } else {
            return $this->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\EventLibrary();
        $viewQueryFields = $library->setListQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())->where('events.id',$id)
            ->join('denominations', 'denominations.id = events.denomination_id')
            ->join('meetings', 'meetings.id = events.meeting_id')
            ->first();
        } else {
            return $this->where('events.id', $id)->first();
        }
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

    public function getListData(){

        $library = new \App\Libraries\EventLibrary();
        $listQueryFields = $library->setListQueryFields();

        $events = [];

        if(session()->get('user_denomination_id')){
            $events = $this->where(['hierarchies.denomination_id' => session()->get('user_denomination_id')])
            ->select(!empty($listQueryFields) ? $listQueryFields : '*')
            ->join('denominations', 'denominations.id = events.denomination_id')
            ->join('meetings', 'meetings.id = events.meeting_id')
            ->findAll();
        }else{
            // $assemblies = $this->getAll();
            $events = $this->select(!empty($listQueryFields) ? $listQueryFields : '*')
            ->join('denominations', 'denominations.id = events.denomination_id')
            ->join('meetings', 'meetings.id = events.meeting_id')
            ->findAll();
        }

        return $events;
    }
}
