<?php

namespace App\Models;

use CodeIgniter\Model;

class MeetingsModel extends Model
{
    protected $table            = 'meetings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','denomination_id','name','description'];

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

    public function getAll() {
        $library = new \App\Libraries\MeetingLibrary();
        $setQueryFields = $library->setListQueryFields();

        if (!empty($setQueryFields)) {
            return $this->select($library->setListQueryFields())->orderBy('meetings.created_at desc')
            ->findAll();
        } else {
            return $this->orderBy('meetings.created_at desc')->findAll();
        }
    }

    public function getOne($id) {
        $library = new \App\Libraries\MeetingLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())->where('id', $id)
            ->findAll();
        } else {
            return $this->where('id', $id)->findAll();
        }
    }

    public function getEditData($department_id){
        $library = new \App\Libraries\MeetingLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('denominations', 'denominations.id = meetings.denomination_id')
                ->where('meetings.id', $department_id)
                ->first();
        } else {
            return $this->where('meetings.id')->first();
        }
    }

    public function getViewData($meeting_id){
        $library = new \App\Libraries\MeetingLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('denominations', 'denominations.id = meetings.denomination_id')
                ->where('meetings.id', $meeting_id)
                ->first();
        } else {
            return $this->where('id', $meeting_id)->first();
        }
    }
}
