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
    protected $uri;
    protected $segments;
    protected $session;
    protected $model = null;

    protected $library = null;
    protected $listQueryFields = [];

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

    protected function page_data($data = [], $id = 0){
        $page_data['result'] = $data;
        $page_data['feature'] = $this->feature;
        $page_data['action'] = $this->action;
        $page_data['id'] = $id;
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

        $page_data['content'] = view($view, $page_data);

        return $page_data;
    }

    public function index()
    {
        $data = [];

        if(method_exists($this->model, 'getAll')){
            $data = $this->model->getAll();
        }else{
            $data = $this->model->findAll();
        }

        if ($this->request->isAJAX()) {
            // $page_data['id'] = $id;
            $page_data = $this->page_data($data);
            return view("$this->feature/list", $page_data);
        }

        return view('index', $this->page_data($data));
    }
    

    public function add(): string {
        return view('index', $this->page_data());
    }

    public function view($id): string {
        $data = $this->model->getOne(hash_id($id,'decode'));
        if(array_key_exists('id',$data)){
            unset($data['id']);
        }

        return view('index', $this->page_data($data, $id));
    }

    public function edit($id): string {
        $data = $this->model->getOne(hash_id($id,'decode'));
        return view('index', $this->page_data($data, $id));
    }

    public function modal($plural_feature, $action, $id = ''){
        $page_data['id'] = $id;
        // log_message('error',json_encode($this->request->getPost()));
        if($action == 'add'){
            
            if(method_exists($this->library, 'getLookUpItems')){
                $page_data['lookup_items'] = $this->library->getLookUpItems(hash_id($id,'decode'));
            }

            return view(singular($plural_feature).DS.$action, $page_data);
        }elseif($action == 'list'){
            $page_data['result'] = $this->model->getItemsByParentId(hash_id($id,'decode'));
            $page_data['feature'] = singular($plural_feature);
            return view(singular($plural_feature).DS.$action, $page_data);
        }else{
            $page_data['result'] = $this->model->getOne(hash_id($id,'decode'));
            return view(singular($plural_feature).DS.$action, $page_data);
        }
    }
}
