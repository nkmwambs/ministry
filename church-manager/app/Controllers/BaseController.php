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
 *     class Home extends WebController
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

   

}
