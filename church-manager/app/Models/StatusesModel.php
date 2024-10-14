<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusesModel extends Model
{
    protected $table            = 'statuses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['task_id','status_label'];

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

    // public function saveStatus($taskId, $statusLabel)
    // {
    //     $existingStatus = $this->where('task_id', $taskId)->first();

    //     if ($existingStatus) {
    //         $this->update($existingStatus['id'], (object)['status_label' => $statusLabel]);
    //     } else {
    //         $this->insert((object)['task_id' => $taskId, 'status_label' => $statusLabel]);
    //     }
    // }

    // public function getStatusesWithTasks()
    // {
    //     return $this->select('statuses.*, tasks.name as task_name')
    //                 ->join('tasks', 'tasks.id = statuses.task_id')
    //                 ->findAll();
    // }
}
