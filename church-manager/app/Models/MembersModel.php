<?php

namespace App\Models;

use CodeIgniter\Model;

class MembersModel extends Model
{
    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','first_name','last_name','gender','assembly_id','parent_id','member_number','designation_id','date_of_birth','email','phone','is_active'];

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
        $library = new \App\Libraries\MemberLibrary();
        $listQueryFields = $library->setListQueryFields();

        if(!empty($listQueryFields)){
            return $this->select($library->setListQueryFields())
            ->join('designations','designations.id = members.designation_id')
            ->orderBy('created_at desc')->findAll();
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
}
