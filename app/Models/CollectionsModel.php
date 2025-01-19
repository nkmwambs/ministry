<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionsModel extends Model
{
    use \App\Traits\DatabaseTrait;
    protected $table            = 'collections';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','return_date','sunday_count','period_start_date','period_end_date','sunday_date','assembly_id','revenue_id','amount','status','collection_reference','description','collection_method'];

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
    protected $parent_schema = ['parent_table','foreign_field_name'];

    protected $lookupTables = ["assemblies","revenues"];

    public function getAll(){
        $library = new \App\Libraries\CollectionLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('assemblies', 'assemblies.id = collections.assembly_id')
            ->join('revenues','revenues.id = collections.revenue_id','left')
            ->orderBy('created_at desc')->findAll();
        }else{
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\CollectionLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('assemblies', 'assemblies.id = collections.assembly_id')
            ->join('revenues','revenues.id = collections.revenue_id','left')
            ->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($collection_id){
        $library = new \App\Libraries\CollectionLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('assemblies', 'assemblies.id = collections.assembly_id')
                ->join('revenues','revenues.id = collections.revenue_id','left')
                ->where('collections.id', $collection_id)
                ->first();
        } else {
            return $this->where('id', $collection_id)->first();
        }
    }

    public function getViewData($collection_id){
        $library = new \App\Libraries\CollectionLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('assemblies', 'assemblies.id = collections.assembly_id')
                ->join('revenues','revenues.id = collections.revenue_id','left')
                ->where('collections.id', $collection_id)
                ->first();
        } else {
            return $this->where('id', $collection_id)->first();
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
