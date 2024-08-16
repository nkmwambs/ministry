<?php

namespace App\Models;

use CodeIgniter\Model;

class EntitiesModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'entities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["hierarchy_id","entity_number","name","parent_id","entity_leader"];

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

    function getAll(){

    }

    function getOne($id){
        
    }

    function getItemsByParentId($hierarchy_id){
        $entities = $this->where('hierarchy_id', $hierarchy_id)
            ->select('id,hierarchy_id,entity_number,name,parent_id,entity_leader')
            ->findAll();

        return $entities;
    }
}
