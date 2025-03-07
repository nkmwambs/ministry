<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class WebController extends BaseController
{

    protected $helpers = ['form', 'church', 'inflector'];
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

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = service('session'); //\Config\Services::session();
        
        if(!$this->session->has('logged_in')){
            // $this->session->destroy();
            // return redirect('logout');
            redirect()->to('logout');
        }

        // Preload any models, libraries, etc, here.
        $this->uri = service('uri');
        $this->segments = $this->uri->getSegments();

        if (isset($this->segments[0]) && (isset($this->segments[0]) == 'church' || isset($this->segments[0]) == 'admin')) {
            $this->feature = isset($this->segments[1]) ? singular($this->segments[1]) : 'dashboard';
            $this->action = isset($this->segments[2]) ? $this->segments[2] : 'list';
            $this->id = isset($this->segments[3]) ? $this->segments[3] : 0;
        } else {
            $this->feature = isset($this->segments[0]) ? singular($this->segments[0]) : 'dashboard';
            $this->action = isset($this->segments[1]) ? $this->segments[1] : 'list';
            $this->id = isset($this->segments[2]) ? $this->segments[2] : 0;
        }

        if (class_exists("App\\Models\\" . plural(ucfirst($this->feature)) . "Model")) {
            $this->model = new ("App\\Models\\" . plural(ucfirst($this->feature)) . "Model")();

            $reflectionClass = new \ReflectionClass($this->model);
            $this->tableName = $reflectionClass->getProperty('table')->getValue($this->model);
        }else{
            $this->tableName = plural($this->feature);
        }

        if (class_exists("App\\Libraries\\" . ucfirst($this->feature) . "Library")) {
            $this->library = new ("App\\Libraries\\" . ucfirst($this->feature) . "Library")();
            $this->listQueryFields = $this->library->setListQueryFields();
        }
    }

    private function history_fields()
    {
        return [
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by',
        ];
    }

    final protected function page_data(object|array $data = null, $id = ''): array
    {
        $data = is_object($data) ? $data->toArray() : $data;
        $page_data['result'] = $data;
        $page_data['feature'] = $this->feature;
        $page_data['action'] = $this->action;
        $page_data['id'] = $this->id;
        $page_data['parent_id'] = $this->parent_id;
        $page_data['tableName'] = $this->tableName;


        $type_view_path = APPPATH . 'Views' . DIRECTORY_SEPARATOR . $this->session->get('user_type') . DIRECTORY_SEPARATOR . $this->feature . DIRECTORY_SEPARATOR . $this->action . '.php';
        $view_path = APPPATH . 'Views' . DIRECTORY_SEPARATOR . $this->feature . DIRECTORY_SEPARATOR . $this->action . '.php';
        $view = "";

        if (file_exists($type_view_path)) {
            $view = $this->session->get('user_type') . "/$this->feature/$this->action";
        } elseif (file_exists($view_path)) {
            $view = "$this->feature/$this->action";
        } else {
            $view = "templates/$this->action";
        }

        if ($data && array_key_exists('errors', $data)) {
            $view = 'errors' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'error_403';
        }

        $page_data['view'] = $view;

        if (!empty($this->listQueryFields)) {
            $page_data['fields'] = $this->listQueryFields;
        } else {
            $reflectionClass = new \ReflectionClass($this->model);
            $tableName = $reflectionClass->getProperty('table')->getValue($this->model);

            // $table_field = $this->model->getFieldNames(plural($this->feature));
            $table_field = $this->model->getFieldNames($tableName);
            $table_field = array_filter($table_field, function ($elem) {
                if (!in_array($elem, $this->history_fields())) {
                    return $elem;
                }
            });
            $page_data['fields'] = $table_field;
        }

        $featureLibrary = new \App\Libraries\FeatureLibrary();
        $page_data['navigation_items'] = $featureLibrary->navigationItems();

        $page_data['designation'] = '';

        return $page_data;
    }

    public function index($id = null)
    {

        if ($this->feature != "dashboard" && !auth()->user()->canDo("$this->feature.read")) {
            $page_data = $this->page_data(['errors' => []]);

            if ($this->request->isAJAX()) {
                return view("errors/html/error_403", $page_data);
            }

            return view('index', compact('page_data'));
        }

        $data = [];

        if (method_exists($this->model, 'getListData')) {
            $data = $this->model->getListData();
        } else {
            method_exists($this->model, 'getAll') ?
                $data = $this->model->getAll() :
                $data = $this->model->findAll();
        }

        if ($id != null) {
            $this->parent_id = $id;
        }

        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'listExtraData')) {
            // Note the editExtraData updates the $page_data by reference
            $this->library->listExtraData($page_data);
        }

        if ($this->request->isAJAX()) {
            return view($this->session->get('user_type') . "/$this->feature/list", $page_data);
        }

        return view('index', compact('page_data'));
    }


    public function view($hashed_id): string
    {
        $data = [];
        $numeric_id = hash_id($hashed_id, 'decode');

        if (method_exists($this->model, 'getViewData')) {
            $data = $this->model->getViewData($numeric_id);
        } else {
            $data = $this->model->getOne($numeric_id);
        }

        $this->parent_id = $hashed_id;
        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'viewExtraData')) {
            // Note the editExtraData updates the $page_data by reference
            $this->library->viewExtraData($page_data);
        }

        // if(array_key_exists('id',$data)){
        if (isset($data) && is_array($data) && array_key_exists('id', $data)) {
            unset($data['id']);
        }

        $customValuesModel = new \App\Models\ValuesModel();
        $page_data['custom_data'] = $customValuesModel->viewAdditionalInformation($this->tableName,$numeric_id);

        if ($this->request->isAJAX()) {
            return view($this->session->get('user_type') . "/$this->feature/view", $page_data);
        }
        
        return view('index', compact('page_data'));
    }

    public function edit(): string
    {
        $numeric_id = hash_id($this->id, 'decode');
        $id = $this->model->find('id');
        if (method_exists($this->model, 'getEditData')) {
            $data = $this->model->getEditData($numeric_id);
        } else {
            $data = $this->model->getOne($numeric_id);
        }

        $page_data = $this->page_data($data);

        if (method_exists($this->library, 'editExtraData')) {
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }

        // foreach ((object)$this->tableName as $table_name) {
        $customFieldLibrary = new \App\Libraries\FieldLibrary();
        $customFields = $customFieldLibrary->getCustomFieldsForTable($this->tableName);
        $customValues = $customFieldLibrary->getCustomFieldValuesForRecord($numeric_id, $this->tableName);
        $page_data['customFields'] = $customFields;
        $page_data['customValues'] = $customValues;
        // }

        // $customValuesModel = new \App\Models\ValuesModel();
        // $page_data['custom_data'] = $customValuesModel->viewAdditionalInformation($this->tableName,$numeric_id);

        if ($this->request->isAJAX()) {
            return view($this->session->get('user_type') . "/$this->feature/edit", $page_data);
        }

        return view('index', compact('page_data'));
    }

    public function delete($id)
    {

        $numeric_id = hash_id($id, 'decode');

        if (method_exists($this->model, 'deleteData')) {
            $this->model->deleteData($numeric_id);
        } else {
            $this->model->delete($numeric_id);
        }
    }

    public function add(): string
    {
        $page_data = $this->page_data();
        // $page_data['parent_id'] = $this->parent_id;

        if (method_exists($this->library, 'addExtraData')) {
            // Note the addExtraData updates the $page_data by reference
            $this->library->addExtraData($page_data);
        }

        foreach ((object) $this->tableName as $table_name) {
            $customFieldLibrary = new \App\Libraries\FieldLibrary();
            $customFields = $customFieldLibrary->getCustomFieldsForTable($table_name);
            $page_data['customFields'] = $customFields;
        }

        return view($this->session->get('user_type') . "/$this->feature/add", $page_data);
    }

    function modal($features, $action, $id = ""): string
    {
        $feature = singular($features);
        $this->feature = $feature;
        $this->action = $action;

        if ($id != "") {
            if ($action == 'add') {
                $this->parent_id = $id;
            } else {
                $this->id = $id;
            }
        }

        if ($action == 'view') {
            return $this->$action($id);
        }

        return $this->$action();
    }


    /**
     * Get getBulkActionFields and their properties
     * Currently works with edit forms
     * @param mixed $tableName
     * @param mixed $actionOnItem
     * @return string
     */
    function getBulkActionFields($tableName, $actionOnItem)
    {
        $view = "Are you sure you want perform this action";
        $selectedItemIds = $this->request->getPost('selectedItems');

        if ($actionOnItem == 'edit') {
            // Get all database table fields metadata  
            $modelName = ucfirst($tableName) . 'Model';
            $model = new ("\App\\Models\\$modelName")();
            $fields = $model->getFieldData($tableName);

            // Filter out fields that are not meant for bulk actions
            $bulkActionFields = array_filter($fields, function ($elem) {
                if (!in_array($elem->name, ['created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'])) {
                    return $elem;
                }
            });

            //Use only editable fields as specified in the model
            $updatableFields = isset($model->bulk_editable_fields) ? $model->bulk_editable_fields : [];

            if (!empty($updatableFields)) {
                $bulkActionFields = array_filter($fields, function ($elem) use ($updatableFields) {
                    if (in_array($elem->name, $updatableFields)) {
                        return $elem;
                    }
                });
            }

            //  Build Enum Options
            $bulkActionFields = array_map(function ($elem) use ($tableName) {
                if ($elem->type == 'enum') {
                    $elem->options = $this->getEnumOptions($tableName, $elem->name);
                }
                return $elem;
            }, $bulkActionFields);

            // Build lookup values options
            $lookUpFields = isset($model->lookUpFields) ? $model->lookUpFields : [];

            if (is_array($lookUpFields) && !empty($lookUpFields)) {
                $bulkActionFields = array_map(function ($elem) use ($model, $lookUpFields) {
                    if (in_array($elem->name, array_keys($lookUpFields))) {
                        if (method_exists($model, 'getLookUpValues')) {
                            $elem->type = 'lookup';
                            $elem->options = $model->getLookUpValues($elem->name, $lookUpFields);
                            $elem->name = $lookUpFields[$elem->name]['nameField'];
                        }

                    }
                    return $elem;
                }, $bulkActionFields);
            }


            // Add custom fields and their associated options
            $customFields = $this->customFields($tableName);

            if (count($customFields) > 0) {
                // Merge $bulkActionFields with $customFields array
                $bulkActionFields = array_merge($bulkActionFields, $customFields);
            }

            // Remove numeric stringified keys
            $bulkActionFields = array_values($bulkActionFields);

            // Get all records that are targeted to be edited
            $selectedItems = $model->whereIn('id', $selectedItemIds)->findAll();

            // Prepare data for view with compact
            $result = compact('tableName', 'bulkActionFields', 'selectedItemIds', 'selectedItems');

            $view = view("templates/bulk_edit", $result);
        }

        return $view;

    }

    /**
     * Build customFields and their options
     * @param mixed $tableName
     * @return object[]
     */
    function customFields($tableName)
    {

        $library = new \App\Libraries\FieldLibrary();
        $customFields = $library->getCustomFieldsForTable($tableName);

        $fields = [];

        foreach ($customFields as $field) {
            $field_code = $field['field_code'];
            $fields[] = (object) [
                "name" => "c__$field_code",
                "type" => $field['type'],
                "options" => $field['options'] != "" ? explode("\r\n", $field['options']) : [],
            ];
        }

        return $fields;
    }

    /**
     * Build of Enum Options
     * @param mixed $tableName
     * @param mixed $columnName
     * @return bool|string[]
     */
    function getEnumOptions($tableName, $columnName)
    {
        $dbName = env('database.default.database');
        $qstring = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$tableName' AND COLUMN_NAME = '$columnName'";

        $result = \Config\Database::connect()->query($qstring)->getResult();
        $options = explode(',', str_replace(['enum(', ')', "'"], '', $result[0]->COLUMN_TYPE));
        return $options;
    }

    function findLookUpFields($model, $tableName, $field_key)
    {
        // Get field data 
        $tableFieldNames = array_column($model->getFieldData($tableName), 'name');

        if (!in_array($field_key, $tableFieldNames)) {
            if (property_exists($model, 'lookUpFields')) {
                $lookUpFields = $model->lookUpFields;
                foreach ($lookUpFields as $key => $lookUpField) {
                    if ($lookUpField['nameField'] == $field_key) {
                        $field_key = $key;
                    }
                }
            }
        }
        return $field_key;
    }

    function bulkEdit()
    {

        $tableName = $this->request->getPost('table_name');
        $edit_selected_ids = $this->request->getPost('edit_selected_ids');

        $modelName = ucfirst($tableName) . "Model";
        $model = new ("\App\\Models\\$modelName")();

        // Building a field / value pairs
        $fields = $this->request->getPost('field');
        $values = $this->request->getPost('value');
        $field_values = array_combine($fields, $values);


        // Seprating normal fields and values from custom ones
        $baseFields = [];
        $customizeFields = [];

        foreach ($field_values as $field_key => $field_value) {
            foreach ($edit_selected_ids as $edit_selected_id) {
                if (substr($field_key, 0, 3) == 'c__') {
                    $customizeFields[$edit_selected_id]['id'] = $edit_selected_id;
                    $customizeFields[$edit_selected_id][substr($field_key, 3)] = $field_value;
                } else {
                    $field_key = $this->findLookUpFields($model, $tableName, $field_key);
                    $baseFields[$edit_selected_id]['id'] = $edit_selected_id;
                    $baseFields[$edit_selected_id][$field_key] = $field_value;
                }
            }

        }

        if (!empty($baseFields)) {
            $model->updateBatch($baseFields, 'id');
        }

        $library = new \App\Libraries\FieldLibrary();
        if (!empty($customizeFields)) {
            $copyCustomizeFields = $customizeFields;
            $lastElemOfCustomizeFields = array_pop($copyCustomizeFields);
            $keysOfCustomizeFields = array_keys($lastElemOfCustomizeFields);
            unset($keysOfCustomizeFields['id']);
            $fieldModel = new \App\Models\FieldsModel();
            $fieldsWithIds = $fieldModel->select('field_code,id')->whereIn('field_code', $keysOfCustomizeFields)->findAll();

            $idsWithKeys = array_combine(array_column($fieldsWithIds, 'field_code'), array_column($fieldsWithIds, 'id'));

            foreach ($customizeFields as $customizeField) {

                $id = $customizeField['id'];
                unset($customizeField['id']);
                foreach ($customizeField as $key => $value) {
                    $rec[$idsWithKeys[$key]] = $value;
                    $library->saveCustomFieldValues($id, $tableName, $rec);
                }
            }
        }


        $customFields = $library->getCustomFieldsForTable($tableName);
        $field_codes = array_column($customFields, 'field_code');

        redirect()->to('assemblies/view/W9');
    }

    public function ajax(?string $controller = "", ?string $method = "", ...$args): ResponseInterface
    {
        // Post keys should be: controller, method and data
        // All ajax request will be received here and passed to library of a controller
        // All ajax responses MUST have a status key with either success or failed
        // When using GET ajax, from the 3rd argument, the paramters MUST be paired with odd positioned parameters as keys and even positioned parameters as values

        if ($controller && $method) {

            $data = [];
            $table_library = null;

            // Check if the args has equal number of odd and even positioned arguments
            if (count($args) % 2 == 1) {
                return $this->response->setJSON(['status' => 'failed', "message" => "Odd number of arguments in ajax request"]);
            }

            // If there are arguments, then set them as an array
            if (count($args) > 0) {
                $data = [];
                for ($i = 0; $i < count($args); $i += 2) {
                    $data[$args[$i]] = $args[$i + 1];
                }
                // Verify if all keys are not numeric keys
                if (array_filter(array_keys($data), 'is_numeric')) {
                    return $this->response->setJSON(['status' => 'failed', "message" => "Numeric keys are not allowed in ajax request"]);
                }
            } else {
                $data = null;
            }

        } else {
            $vars = $this->request->getPost();
            extract($vars);
        }

        $table_library_name = ucfirst(singular($controller) . 'Library');

        if (class_exists("App\\Libraries\\$table_library_name")) {
            // Instantiate the library class
            $table_library = new ("App\\Libraries\\$table_library_name")();
        }

        if ($table_library == null) {
            // To be updated and allow automatic creation of feature library files
            throw new \Exception("Object '$table_library_name' could not be instantiated");
        }

        $response = $table_library->{$method}($data);

        // If the method returns a response, add a message key with either success or failure
        if (isset($response['status'])) {
            return $this->response->setJSON($response);
        } else {
            $response['status'] = 'failed';
            $response['message'] = 'Wrongly formatted response';
            return $this->response->setJSON($response);
        }
    }

    function getRecords(): array
    {
        $columns = sanitizeColumns($this->tableName, $this->library->setListQueryFields())['queryColumns'];
        
        $search_columns = $columns;

        // Limiting records
        $start = intval($this->request->getPost('start'));
        $length = intval($this->request->getPost('length'));

        $this->model->limit($length, $start);

        // Ordering records

        $order = $this->request->getPost('order');
        $col = '';
        $dir = 'desc';

        if (!empty($order)) {
            $col = $order[0]['column'];
            $dir = $order[0]['dir'];
        }

        if ($col == '') {
            $this->model->orderBy(plural($this->feature).'.id DESC');
        } else {
            $this->model->orderBy($columns[$col], $dir);
        }

        // Searching

        $search = $this->request->getPost('search');
        $value = $search['value'];

        array_shift($search_columns);

        if (!empty($value)) {
            $this->model->groupStart();
            $column_key = 0;
            foreach ($search_columns as $column) {
                if ($column_key == 0) {
                    $this->model->like($column, $value, 'both');
                } else {
                    $this->model->orLike($column, $value, 'both');
                }
                $column_key++;
            }
            $this->model->groupEnd();
        }

        $this->model->select($columns);

        if($this->request->getPost('parent_table') && $this->request->getPost('parent_id')){
            $parentTable = $this->request->getPost('parent_table');
            $parentId = hash_id($this->request->getPost('parent_id'),'decode', 'array');

            if(!is_array($parentId)){
                $parentId = [$parentId];
            }

            $this->model->tableJoins([$parentTable => $parentId]);
        }else{
            $this->model->tableJoins();
        }


        $results = $this->model->findAll();

        return $results;
    }



    function countRecords()
    {

        $columns = $this->library->setListQueryFields();
        $search_columns = $columns;

        // Searching

        $search = $this->request->getPost('search');
        $value = $search['value'];

        array_shift($search_columns);

        // if (!empty($value)) {
        //     $this->model->groupStart();
        //     $column_key = 0;
        //     foreach ($search_columns as $column) {
        //         if ($column_key == 0) {
        //             $this->model->like($column, $value, 'both');
        //         } else {
        //             $this->model->orLike($column, $value, 'both');
        //         }
        //         $column_key++;
        //     }
        //     $this->model->groupEnd();
        // }
        $this->model->tableJoins();
        $count_all_results = $this->model->countAllResults();

        return $count_all_results;
    }


    function showList()
    {
        $draw = intval($this->request->getPost('draw'));
        $records = $this->getRecords();
        $countRecords = $this->countRecords();

        $result = [];

        $cnt = 0;
        foreach ($records as $record) {
            foreach ($record as $key => $value){
                if($key == 'id'){
                    $actionButtons = auth()->user()->canDo("$this->feature.update") ? '<a class = "btn btn-info action_btn" href="'.site_url("church/".plural($this->feature)."/edit/".hash_id($record['id'],'encode')).'">Edit</a>' : '';
                    $actionButtons .= '<a class = "btn btn-success action_btn" href="'.site_url("church/".plural($this->feature)."/view/".hash_id($record['id'],'encode')).'">View</a>';
                    $actionButtons .= auth()->user()->canDo("$this->feature.delete") ? '<a class = "btn btn-danger action_btn action_delete" href="#" data-id="'.hash_id($record['id'],'encode').'">Delete</a>' : '';
                    $record['id'] = $actionButtons;
                }
            }
            $row = array_values($record);
            $result[$cnt] = $row;
            $cnt++;
        }

        $response = [
            'draw' => $draw,
            'recordsTotal' => $countRecords,
            'recordsFiltered' => $countRecords,
            'data' => $result
        ];

        return $this->response->setJSON($response);
    }

}
