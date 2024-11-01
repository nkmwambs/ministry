<?php 

namespace App\Libraries;

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
        $featuresModel = new \App\Models\FeaturesModel();
        $features = $featuresModel->findAll(); 

        $permissionsModel = new \App\Models\PermissionsModel();
        $roleAssignedFeatures = $permissionsModel
        ->select('permissions.id,role_id,features.id as feature_id,features.name as feature_name,permission_label,allowable_permission_labels')
        ->join('features', 'features.id=permissions.feature_id')
        ->where('role_id', $page_data['result']['id'])->findAll();

        $roleAssignedFeatureIds = array_column($roleAssignedFeatures, 'feature_id');

        foreach ($features as $key => $feature) {
            if(in_array($feature['id'], $roleAssignedFeatureIds)){
                unset($features[$key]);
            }
        }

        $page_data['features'] = $features;

        // List assigned permissions
        $page_data['role_assigned_features'] = $roleAssignedFeatures;
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

        $featuresModel = new \App\Models\FeaturesModel();
        $features = $featuresModel->findAll();

        $page_data['denominations'] = $denominations;
        $page_data['features'] = $features;
    } 

    function viewEditExtraData(&$page_data) {
        // $page_data['feature_id'] = hash_id($feature_id,'encode');
    }

    static function buildPermissions(): array{
        // Add your logic to build permissions here
        $featuresModel= new \App\Models\FeaturesModel();
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
}