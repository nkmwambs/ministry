<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['tasks.id','tasks.name','tasks.status','user_id'];

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
        $library = new \App\Libraries\TaskLibrary();
        $setQueryFields = $library->setListQueryFields();

        if (!empty($setQueryFields)) {
            return $this->select($library->setListQueryFields())
            ->orderBy('roles.created_at desc')->findAll();
        } else {
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    function getOne($id){
        $library = new \App\Libraries\TaskLibrary;
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
            ->where('id', $id)->first();
        } else {
            return $this->where('id', $id)->first();
        }
    }
    
    public function getEditData($task_id){
        // log_message('error', json_encode($role_id));
        $library = new \App\Libraries\TaskLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('users', 'users.id = tasks.user_id', 'left')
                ->where('tasks.id', $task_id)
                ->first();
        } else {
            return $this->where('id', $task_id)->first();
        }
    }

    public function getViewData($role_id){
        $library = new \App\Libraries\TaskLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('users', 'users.id = tasks.user_id')
                ->where('tasks.id', $role_id)
                ->first();
        } else {
            return $this->where('id', $role_id)->first();
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
}
