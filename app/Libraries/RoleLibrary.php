<?php 

namespace App\Libraries;

use App\Models\FeaturesModel;

class RoleLibrary implements \App\Interfaces\LibraryInterface {

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['roles.id','roles.name','default_role','denomination_id','denominations.name as denomination_name'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['roles.id','roles.name','default_role','denomination_id','denominations.name as denomination_name'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }

    function viewExtraData(&$page_data){
        $features = [];

        // Get list of features
        $featuresModel = new FeaturesModel();
        $features = $featuresModel->findAll(); 

        $rolesModel = new \App\Models\RolesModel();
        
        $roleAssignedFeaturesJsonString = $rolesModel->select('permissions')->find($page_data['result']['id'])['permissions'];

        $roleAssignedFeatures = $this->keyedPermissions($roleAssignedFeaturesJsonString, $features);

        $roleAssignedFeatureNames = array_column($roleAssignedFeatures, 'feature_name');

        foreach ($features as $key => $feature) {
            if(in_array($feature['name'], $roleAssignedFeatureNames)){
                unset($features[$key]);
            }
        }

        $page_data['features'] = $features;

        // List assigned permissions
        $page_data['role_assigned_features'] = $roleAssignedFeatures;
    }

    private function keyedPermissions(string $json_permissions, array $features): array{
        $keyedPermissions = [];
        $array_permissions = json_decode($json_permissions); 

        $ids = array_column($features, 'id');
        $names = array_column($features, 'name');
        $allowable_permission_labels = array_column($features, 'allowable_permission_labels');

        $feature_names_ids = array_combine($names, $ids);
        $feature_names_labels = array_combine($names, $allowable_permission_labels);

        $cnt = 0;
        if(!empty($array_permissions)){
            foreach($array_permissions as $permissionSet){
                $permissionSetArray = explode('.', $permissionSet);
                $keyedPermissions[$cnt]['feature_name'] = $permissionSetArray[0];
                $keyedPermissions[$cnt]['feature_id'] =   $feature_names_ids[$permissionSetArray[0]];
                $keyedPermissions[$cnt]['allowable_permission_labels'] =   $feature_names_labels[$permissionSetArray[0]];
                $keyedPermissions[$cnt]['permission_label'] =   $permissionSetArray[1] == "*" ? "delete" : $permissionSetArray[1];
                $cnt++;
            }
        }

        return $keyedPermissions;
    }

    function addExtraData(&$page_data) {
        $parent_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $page_data['denominations'] = $denominations;

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }

    function editExtraData (&$page_data) {
        $numeric_denomination_id = 0;
        $numeric_feature_id = 0;

        if (session()->get('user_denomination_id')) {
            $numeric_denomination_id = session()->get('user_denomination_id');
        }

        $page_data['numeric_denomination_id'] = $numeric_denomination_id;
        $page_data['numeric_feature_id'] = $numeric_feature_id;
        
        $denominationsModel = new \App\Models\DenominationsModel();
        $denominations = $denominationsModel->findAll();

        $featuresModel = new FeaturesModel();
        $features = $featuresModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['features'] = $features;
    } 

    function viewEditExtraData(&$page_data) {
        // $page_data['feature_id'] = hash_id($feature_id,'encode');
    }

    static function buildPermissions(): array{
        // Add your logic to build permissions here
        $featuresModel= new FeaturesModel();
        $features = $featuresModel->findAll();
        $permissions = [];
        foreach($features as $feature){
            $allowable_permission_labels = json_decode($feature['allowable_permission_labels']);
            foreach($allowable_permission_labels as $permission_label){
                $permissions[$feature['name'].'.'.$permission_label] = $feature['description'];
            }
        }
        return $permissions;
    }

    function updatePermissionString(FeaturesModel $featuresModel, \App\Models\RolesModel $rolesModel, int $feature_id, int $role_id, string $permission_label): string{
        $feature = $featuresModel->find($feature_id);
        $feature_name = $feature['name'];

        $currentPermissionsJsonString = $rolesModel->find($role_id)['permissions'];
        $currentPermissions = json_decode( $currentPermissionsJsonString, true );

        for($i = 0; $i < sizeof($currentPermissions ); $i++){
            $currentPermissionArray = explode(".", $currentPermissions[$i]);
            if($currentPermissionArray[0] == $feature_name){
                $currentPermissions[$i] = "$feature_name.$permission_label";
            }
        }

        $updatedPermissionsJsonString = json_encode($currentPermissions);
        // $data = ['permissions' => $updatedPermissionsJsonString];
        return $updatedPermissionsJsonString;
    }
}