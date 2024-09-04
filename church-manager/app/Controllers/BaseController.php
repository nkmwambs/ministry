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
    protected $listQueryFields = [];

    protected $feature_page_data = [];

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

    protected function page_data($data = [], $id = ''){
        $page_data['result'] = $data;
        $page_data['feature'] = $this->feature;
        $page_data['action'] = $this->action;
        $page_data['id'] = $this->id;
        $page_data['parent_id'] = $this->parent_id;

        $view_path = APPPATH.'Views'.DIRECTORY_SEPARATOR.$this->feature.DIRECTORY_SEPARATOR.$this->action.'.php';
        $view = file_exists($view_path) ?  "$this->feature/$this->action" : "templates/$this->action";

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
       
        if(!$this->request->isAJAX()){
            $page_data['content'] = view($view, $page_data); // Use in the index page to load content 
        }

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
            $data = $this->model->findAll();
        }
        

        if ($this->request->isAJAX()) {
            // $page_data['id'] = $id;
            $page_data = $this->page_data($data);
            return view("$this->feature/list", $page_data);
        }

        return view('index', $this->page_data($data));
    }
    

    public function view($hashed_id): string {
        $data = [];
        $numeric_id = hash_id($hashed_id,'decode');
        
        if(method_exists($this->model, 'getViewData')){
            $data = $this->model->getViewData($numeric_id);
        }else{
            $data = $this->model->getOne($numeric_id);
        }

        if(array_key_exists('id',$data)){
            unset($data['id']);
        }

        return view('index', $this->page_data($data));
    }

    public function edit(): string {
        $numeric_id = hash_id($this->id,'decode');

        if(method_exists($this->model, 'getViewData')){
            $data = $this->model->getEditData($numeric_id);
        }else{
            $data = $this->model->getOne($numeric_id);
        }

        $page_data = $this->page_data($data);
        
        if(method_exists($this->library,'editExtraData')){
            // Note the editExtraData updates the $page_data by reference
            $this->library->editExtraData($page_data);
        }

        return view("$this->feature/edit", $page_data);
    }

    public function add(): string {
        $page_data = $this->page_data();
        $page_data['parent_id'] = $this->parent_id;

        if(method_exists($this->library,'addExtraData')){
            // Note the addExtraData updates the $page_data by reference
            $this->library->addExtraData($page_data);
        }

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

}
