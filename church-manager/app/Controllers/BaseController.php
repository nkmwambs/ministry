<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['form','church','inflector'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    protected $feature = '';
    protected $action = '';
    protected $id = 0;
    protected $parent_id = 0;
    protected $uri;
    protected $segments;
    protected $session;
    protected $model = null;
    protected $library = null;
    protected $tableName = null;
    protected $customFields = null;
    protected $listQueryFields = [];

    protected $feature_page_data = [];

    // private $client;
    // private $base_url;
    function __construct(){
        
    }

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->session = \Config\Services::session();
        $this->uri = service('uri');
        $this->segments = $this->uri->getSegments();
        $this->feature = isset($this->segments[0]) ? singular($this->segments[0]) : 'dashboard';
        $this->action = isset($this->segments[1]) ? $this->segments[1] : 'list';
        $this->id = isset($this->segments[2]) ? $this->segments[2] : 0;

        if(class_exists("App\\Models\\" . plural(ucfirst($this->feature)) . "Model")){
            $this->model = new ("App\\Models\\" . plural(ucfirst($this->feature)) . "Model")();
        }

        if(class_exists("App\\Libraries\\" . ucfirst($this->feature) . "Library")){
            $this->library = new ("App\\Libraries\\" . ucfirst($this->feature) . "Library")();
            $this->listQueryFields = $this->library->setListQueryFields();
        }
        
        $this->tableName = plural($this->feature);

    }

    private function history_fields(){
        return [
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by',
        ];
    }

    final protected function page_data($data = [], $id = ''){
        $page_data['result'] = $data;
        $page_data['feature'] = $this->feature;
        $page_data['action'] = $this->action;
        $page_data['id'] = $this->id;
        $page_data['parent_id'] = $this->parent_id;
        $page_data['tableName'] = $this->tableName;
        

        $view_path = APPPATH.'Views'.DIRECTORY_SEPARATOR.$this->feature.DIRECTORY_SEPARATOR.$this->action.'.php';
        $view = file_exists($view_path) ?  "$this->feature/$this->action" : "templates/$this->action";
        $page_data['view'] = $view;

        if(!empty($this->listQueryFields)){
            $page_data['fields'] = $this->listQueryFields;
        }else{
            $table_field = $this->model->getFieldNames(plural($this->feature));
            $table_field = array_filter($table_field, function ($elem){
                if(!in_array($elem, $this->history_fields())){
                    return $elem;
                }
            });
            $page_data['fields'] = $table_field;
        }
       
        $featureLibrary = new \App\Libraries\FeatureLibrary();
        $page_data['navigation_items'] = $featureLibrary->navigationItems();
        // $page_data['extra_data'] = [];
        // if(!$this->request->isAJAX()){
            // $page_data['content'] = view($view, $page_data); // Use in the index page to load content 
        // }

        // log_message('error', json_encode($page_data));

        return $page_data;
    }

    public function index()
    {
        $data = [];
        
        if(method_exists($this->model, 'getListData')){
            $data = $this->model->getListData();
        }else{
            method_exists($this->model, 'getAll') ?
            $data = $this->model->getAll() :
            // log_message('error', json_encode($data));
            $data = $this->model->findAll();
        }
        
        $page_data = $this->page_data($data);

        if(method_exists($this->library,'listExtraData')){  
            // Note the editExtraData updates the $page_data by reference
            $this->library->listExtraData($page_data);
        }

        if ($this->request->isAJAX()) {
            return view("$this->feature/list", $page_data);
        }

        // log_message('error', json_encode($page_data));
 
        return view('index', compact('page_data'));
    }
    

    public function view($hashed_id): string {
        $data = [];
        $numeric_id = hash_id($hashed_id,'decode');
        
        if(method_exists($this->model, 'getViewData')){
            $data = $this->model->getViewData($numeric_id);
        }else{
            $data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $hashed_id;
        $page_data = $this->page_data($data);
        
        if(method_exists($this->library,'viewExtraData')){  
            // Note the editExtraData updates the $page_data by reference
            $this->library->viewExtraData($page_data);
        }

        // if(array_key_exists('id',$data)){
        if (isset($data) && is_array($data) && array_key_exists('id', $data)) {
            unset($data['id']);
        }

        if($this->request->isAJAX()){
            return view("$this->feature/view", $page_data);
        }
        // log_message('error', json_encode($page_data));

        return view('index', compact('page_data'));
    }

    public function edit(): string {
        $numeric_id = hash_id($this->id,'decode');
        $id = $this->model->find('id');
        if(method_exists($this->model, 'getEditData')){
            $data = $this->model->getEditData($numeric_id);
        }else{
            $data = $this->model->getOne($numeric_id);
        }

        $page_data = $this->page_data($data);
        
        if(method_exists($this->library,'editExtraData')){
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }

        foreach ((object)$this->tableName as $table_name) {
            $customFieldLibrary = new \App\Libraries\FieldLibrary();
            $customFields = $customFieldLibrary->getCustomFieldsForTable($table_name);
            $customValues = $customFieldLibrary->getCustomFieldValuesForRecord($numeric_id, $table_name);
            $page_data['customFields'] = $customFields;
            $page_data['customValues'] = $customValues;
            // log_message('error', json_encode($customValues));
        }

        return view("$this->feature/edit", $page_data);
    }

    public function delete($id){
       
        $numeric_id = hash_id($id,'decode');

        if(method_exists($this->model, 'deleteData')){
            $this->model->deleteData($numeric_id);
        } else{
            $this->model->delete($numeric_id);
        }

        // return redirect()->to($this->feature);
        // return view("$this->feature/edit", $page_data);
    }

    public function add(): string {
        $page_data = $this->page_data();
        // $page_data['parent_id'] = $this->parent_id;

        if(method_exists($this->library,'addExtraData')){
            // Note the addExtraData updates the $page_data by reference
            $this->library->addExtraData($page_data);
        }

        foreach ((object)$this->tableName as $table_name) {
            $customFieldLibrary = new \App\Libraries\FieldLibrary();
            $customFields = $customFieldLibrary->getCustomFieldsForTable($table_name);
            $page_data['customFields'] = $customFields;
            // log_message('error', json_encode($customFields));
        }

        
        // log_message('error', json_encode($page_data));
        return view("$this->feature/add", $page_data);
    }

    function modal($features, $action, $id = ""): string {        
        $feature = singular($features);
        $this->feature = $feature;
        $this->action = $action;

        if($id != ""){
            if($action == 'add'){
                $this->parent_id = $id;
            }else{
                $this->id = $id;
            }
        }

        if($action == 'view'){
            return $this->$action($id);
        }
        
        return $this->$action();
    }


    function getBulkActionFields($tableName, $actionOnItem){
        $view = "Are you sure you want perform this action";
        $selectedItemIds = $this->request->getPost('selectedItems');

        // log_message('error', json_encode($selectedItems));

        if($actionOnItem == 'edit'){
            // Get all database table fields metadata  
            $modelName = ucfirst($tableName).'Model';
            $model = new ("\App\\Models\\$modelName")(); 
            $fields = $model->getFieldData($tableName);
            
            // Filter out fields that are not meant for bulk actions
            $bulkActionFields = array_filter($fields, function ($elem){
                if(!in_array($elem->name, ['created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'])){
                    return $elem;
                }
            }); 

            $updatableFields = isset($model->bulk_editable_fields) ? $model->bulk_editable_fields : [];

            if(!empty($updatableFields)){
                $bulkActionFields = array_filter($fields, function ($elem) use($updatableFields){
                    if(in_array($elem->name, $updatableFields)){
                        return $elem;
                    }
                });
            }

            $bulkActionFields = array_map(function($elem) use($tableName){
                if($elem->type == 'enum'){
                    $elem->options = $this->getEnumOptions($tableName,$elem->name);
                }
                return $elem;
            }, $bulkActionFields);
            
            $customFields = $this->customFields($tableName);

            if(count($customFields) > 0){
                // Merge $bulkActionFields with $customFields array
                $bulkActionFields = array_merge($bulkActionFields, $customFields);
            }

            $bulkActionFields = array_values($bulkActionFields); 
            
            $selectedItems = $model->whereIn('id', $selectedItemIds)->findAll();
            $result = compact('tableName','bulkActionFields','selectedItemIds', 'selectedItems');
            // log_message('error', json_encode($result));
            $view  = view("templates/bulk_edit", $result);
        }
        
        return $view;
        
    }

    function customFields($tableName){

        $library = new \App\Libraries\FieldLibrary();
        $customFields = $library->getCustomFieldsForTable($tableName);

        $fields = [];

        foreach($customFields as $field){
            $field_code = $field['field_code'];
            $fields[] = (object)[
                "name" => "c__$field_code",
                "type" => $field['type'],
                "options" => $field['options'] != "" ? explode("\r\n",$field['options']) : [],
            ];
        }

        return $fields;
    }

    function getEnumOptions($tableName, $columnName) {
        $dbName = env('database.default.database');
        $qstring="SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$tableName' AND COLUMN_NAME = '$columnName'";

        $result = \Config\Database::connect()->query($qstring)->getResult();
        $options = explode(',', str_replace(['enum(', ')', "'"], '', $result[0]->COLUMN_TYPE));
        return $options;
    }

    function bulkEdit(){
        $tableName = $this->request->getPost('tableName');
        log_message('error', json_encode($this->request->getPost()));
        redirect()->to('assemblies/view/W9');
    }

}
