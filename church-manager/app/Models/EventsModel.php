<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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
        $library = new \App\Libraries\EntityLibrary();
        $listQueryFields = $library->setListQueryFields();

        if (!empty($listQueryFields)) {
            return $this->select($library->setListQueryFields())->findAll();
        } else {
            return $this->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\EntityLibrary();
        $viewQueryFields = $library->setListQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())->where('id',$id)->first();
        } else {
            return $this->where('id', $id)->first();
        }
    }
}
