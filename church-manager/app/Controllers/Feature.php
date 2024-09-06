<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Feature extends BaseController
{

    protected $model = null;

    function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
        parent::initController($request, $response, $logger);
        
        $this->model = new \App\Models\FeaturesModel();
    }

    function getAllowablePermissionLabels($feature_id){
        $allowable_permission_labels = $this->model->where('id', $feature_id)->first()['allowable_permission_labels'];
        return $this->response->setJSON(compact('allowable_permission_labels'));
    }
}
