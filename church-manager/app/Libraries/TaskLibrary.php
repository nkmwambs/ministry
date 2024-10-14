<?php 

namespace App\Libraries;

class TaskLibrary implements \App\Interfaces\LibraryInterface {

    private $request;
    private $model = null;

    function __construct(){
        $this->request = service('request');
        $this->model = new \App\Models\TasksModel();
    }

    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = ['tasks.id','tasks.name','tasks.status','user_id'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = ['tasks.id','tasks.name','tasks.status','user_id','users.first_name as user_name'];
        return $fields;
    }

    function listExtraData(&$page_data) {
        
        $parent_id = 0;
        // $user_id = 0;

        if (session()->get('user_denomination_id')) {
            $parent_id = session()->get('user_denomination_id');
        }

        $page_data['parent_id'] = hash_id($parent_id,'encode');
    }

    // function viewExtraData(&$page_data){
    //     $tasks = [];

    //     $tasksModel = new \App\Models\TasksModel();
    //     $tasks = $tasksModel->findAll();

    //     $statusesModel = new \App\Models\StatusesModel();
    //     $statusAssignedTasks = $statusesModel
    //     ->select('statuses.id,tasks.id as task_id,user_id,tasks.name as task_name,status_label')
    //     ->join('tasks', 'tasks.id=statuses.task_id')
    //     ->where('user_id', $page_data['result']['id'])->findAll();
    //     log_message('error', json_encode($statusAssignedTasks));

    //     $statusAssignedTasksIds = array_column($statusAssignedTasks, 'task_id');

    //     foreach ($tasks as $key => $task) {
    //         if (in_array($task['id'], $statusAssignedTasksIds)) {
    //             unset($task[$key]);
    //         }
    //     }

    //     $page_data['tasks'] = $tasks;

    //     $page_data['status_assigned_tasks'] = $statusAssignedTasks;
    // }

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


    public function updateStatus()
    {
        $data = $this->request->getPost('data');
        $names = array_column($data, 'name');
        $values = array_column($data, 'value');
        $postArr = array_combine($names, $values);
      
        $this->model->save($postArr);
        
    }
}