<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    use \App\Traits\DatabaseTrait;
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $nameField        = "first_name";
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','first_name','last_name','saved_date','gender','membership_date','assembly_id','parent_id','inactivation_reason','inactivation_date','member_number','designation_id','date_of_birth','email','phone','is_active'];

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
    protected $lookupTables = ["designations","assemblies"];

    protected $bulk_editable_fields = ['gender','membership_date','designation_id','saved_date','is_active','inactivation_reason','assembly_id'];

    protected $lookUpFields = [
        'designation_id' => ['tableName' => 'designations', 'nameField' => 'designation_name'],
        'assembly_id' => ['tableName' => 'assemblies', 'nameField' => 'assembly_name']
    ];

    function listAssemblyCondition(){
        if(!empty(session()->user_permitted_assemblies)){
            $this->whereIn('assemblies.id', session()->user_permitted_assemblies);
        }
    }

    public function getAll(){
        $library = new \App\Libraries\MemberLibrary();
        $listQueryFields = $library->setListQueryFields();

        $this->listAssemblyCondition();
        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('designations','designations.id = members.designation_id')
            ->join('assemblies','assemblies.id = members.assembly_id')
            ->orderBy('members.created_at desc')->findAll();
        }else{
            return $this->orderBy('created_at desc')->findAll();
        }
    }

    public function getOne($id){
        $library = new \App\Libraries\MemberLibrary();
        $viewQueryFields = $library->setViewQueryFields();
        
        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())->where('id', $id)->first();
        }else{
            return $this->where('id', $id)->first();
        }
    }

    public function getEditData($member_id){
        $library = new \App\Libraries\MemberLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        $this->listAssemblyCondition();

        if (!empty($viewQueryFields)) {
            return $this->select($library->setViewQueryFields())
                ->join('assemblies', 'assemblies.id = members.assembly_id')
                ->join('designations','designations.id = members.designation_id')
                ->where('members.id', $member_id)
                ->first();
        } else {
            return $this->join('designations','designations.designation_id = members.designation_id')
            ->where('id', $member_id)->first();
        }
    }

    public function getViewData($member_id){
        $library = new \App\Libraries\MemberLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        $this->listAssemblyCondition();

        if (!empty($viewQueryFields)) {
            $result = $this->select($library->setViewQueryFields()) 
                ->join('assemblies', 'assemblies.id = members.assembly_id')
                ->join('designations','designations.id = members.designation_id')
                ->where('members.id', $member_id)
                ->first();
                
                unset($result['id']);
                unset($result['assembly_id']);
                unset($result['designation_id']);

                return $result;
        } else {
            return $this->where('id', $member_id)->first();
        }
    }

    public function getMembersByAssemblyId($assembly_id)
    {
        return $this->where('assembly_id', $assembly_id)->findAll();
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

    function getLookUpValues($fieldName, $lookUpFields){
        $lookupTable = $lookUpFields[$fieldName]['tableName'];
        $modelName = ucfirst($lookupTable).'Model';
        $model = new ("\App\\Models\\$modelName")(); 

        $table_has_denomination_id = in_array('denomination_id',array_column($model->getFieldData($lookupTable),'name'));
        
        $denomination_id = 0;

        if (session()->get('user_denomination_id')) {
            $denomination_id = session()->get('user_denomination_id');
        }

        if($table_has_denomination_id && $denomination_id > 0){
            return $model->where('denomination_id', $denomination_id)->select('id,name')->findAll();
        }else{
            return $model->select('id,name')->findAll();
        }

    }
}
