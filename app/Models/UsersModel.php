<?php

namespace App\Models;

// use CodeIgniter\Model;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;


class UsersModel extends ShieldUserModel  implements \App\Interfaces\ModelInterface
{
    
    protected $table            = 'users';

    protected $returnType     = \App\Entities\User::class;

    // protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';// \App\Entities\UserEntity::class;
    // protected $useSoftDeletes   = true;
    // protected $protectFields    = true;
   
    protected $allowedFields    = [
        'username',
        'status',
        'status_message',
        'active',
        'last_active',
        "id","denomination_id",
        "first_name","last_name",
        "biography",
        "date_of_birth","email",
        "gender","phone","roles",
        "access_count",
        "is_active",
        "permitted_entities",
        "permitted_assemblies",
        "created_at",
        "updated_at",
        "password"
    ];

    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;
    // protected array $casts = [];
    // protected array $castHandlers = [];
    // // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    protected $afterInsert   = ['saveEmailIdentity', "updateUserRoles"];
    // protected $beforeUpdate   = [];
    protected $afterUpdate    = ['saveEmailIdentity'];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    protected $afterDelete    = ['updateRecycleBin'];

    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
            "id","denomination_id",
            "first_name","last_name",
            "username","biography",
            "date_of_birth","email",
            "gender","phone","roles",
            "access_count", 
            "permitted_entities",
            "permitted_assemblies"
        ];
    }

    
    function getAll(){
        $library = new \App\Libraries\UserLibrary();
        $listQueryFields = $library->setListQueryFields();

        if (!empty($listQueryFields)) {
            return $this->select($library->setListQueryFields())->orderBy('created_at desc')->findAll();
        } else {
            $this->orderBy('created_at desc')->findAll();
        }
    }

    function getOne($id){
        $library = new \App\Libraries\UserLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        array_push($viewQueryFields, 'auth_identities.secret as email');

        if (!empty($viewQueryFields)) {
            return $this
            ->join("auth_identities","auth_identities.user_id=users.id")
            ->select($library->setViewQueryFields())->where('id', $id)->first();
        } else {
            $this->where('id', $id)->first();
        }
    }

    public function getEditData($user_id){
        $library = new \App\Libraries\UserLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=users.denomination_id','left')
            ->where('users.id', $user_id)->first();
            // return $var_return;
        }else{
            return $this->where('id', $user_id)->first();
        }
    }

    public function getViewData($user_id){
        $library = new \App\Libraries\UserLibrary();
        $viewQueryFields = $library->setViewQueryFields();

        if(!empty($viewQueryFields)){
            return $this->select($library->setViewQueryFields())
            ->join('denominations','denominations.id=users.denomination_id')
            ->where('users.id', $user_id)->first();
        }else{
            return $this->where('id', $user_id)->first();
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

    function updateUserRoles($data): array {
        $db = \Config\Database::connect();
        $builder = $db->table('auth_groups_users');

        $user_id = $data['id'];
        $rolesString = $data['data']['roles'];
        $roles = json_decode($rolesString);

        $rolesModel = new RolesModel();
        $rolesResult = $rolesModel->whereIn('id', $roles)->findAll();
        $rolesNames = array_column($rolesResult,'name');

        // Remove roles assignments
        $assignmentCount = $builder->where('user_id', $user_id)->countAllResults();
        if($assignmentCount > 0){
            $builder->where('user_id', $user_id)->delete();
        }
        
        $batch = [];

        for($i = 0; $i < sizeof($rolesNames); $i++){
            $batch[$i] = [
                'user_id' => $user_id,
                'group' => $rolesNames[$i],
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        // Database Connection
        $builder->insertBatch($batch);

        $data['data']['roles'] = NULL;

        return $data;
    }
}
