<?php

namespace App\Controllers\Admin;

use App\Controllers\WebController;
use CodeIgniter\HTTP\ResponseInterface;

class Permission extends WebController
{
    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\PermissionsModel();
    }

    function updatePermission(){
        $permissionModel = new \App\Models\PermissionsModel();
        $role_id = $this->request->getPost('role_id');
        $feature_id = $this->request->getPost('feature_id');
        $permission_label = $this->request->getPost('permission_label');

        $countAssignedFeatureRoles = $permissionModel->where(['role_id' => $role_id, 'feature_id' => $feature_id])->countAllResults();
        // log_message('error', json_encode($countAssignedFeatureRoles));
        if($countAssignedFeatureRoles == 0){
            $this->model->insert($this->request->getPost());
        }else{
            $permission_id = $permissionModel->where(['role_id' => $role_id, 'feature_id' => $feature_id])->first()['id'];
            $permissionModel->update($permission_id, (object)['permission_label' => $permission_label]);
        }
    }
}
