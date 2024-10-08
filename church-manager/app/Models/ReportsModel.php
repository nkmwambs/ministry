<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportsModel extends Model  implements \App\Interfaces\ModelInterface
{
    protected $table            = 'reports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','reports_type_id','report_period','report_date','status'];

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
        $library = new \App\Libraries\ReportLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('reporttypes', 'reporttypes.id = reports.reports_type_id')
            ->orderBy('reports.created_at desc')
            ->findAll();
        }else{
            return $this->orderBy('reports.created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\ReportLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('reporttypes', 'reporttypes.id = reports.reports_type_id')
            ->orderBy('reports.created_at desc')
            ->where('reports.id', $id)
            ->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($report_id){
        $library = new \App\Libraries\ReportLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('reporttypes', 'reporttypes.id = reports.reports_type_id')
                ->where('reports.id', $report_id)
                ->first();
        } else {
            return $this->where('id', $report_id)->first();
        }
    }

    public function getViewData($minister_id){
        $library = new \App\Libraries\ReportLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields()) 
                ->join('reporttypes', 'reporttypes.id = reports.reports_type_id')
                ->where('reports.id', $minister_id)
                ->first();
        } else {
            return $this->where('id', $minister_id)->first();
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
