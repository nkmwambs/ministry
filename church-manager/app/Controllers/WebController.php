<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class WebController extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
    }

    public function ajax(?string $controller = "", ?string $method = "", ...$args): ResponseInterface
    {
        // Post keys should be: controller, method and data
        // All ajax request will be received here and passed to library of a controller
        // All ajax responses MUST have a status key with either success or failed
        // When using GET ajax, from the 3rd argument, the paramters MUST be paired with odd positioned parameters as keys and even positioned parameters as values
    
        if($controller && $method){
    
            $data = [];
            $table_library = null;
    
            // Check if the args has equal number of odd and even positioned arguments
            if(count($args) % 2 == 1){
                return $this->response->setJSON(['status' => 'failed', "message" => "Odd number of arguments in ajax request"]);
            }
    
            // If there are arguments, then set them as an array
            if(count($args) > 0){
                $data = [];
                for($i=0; $i<count($args); $i+=2){
                    $data[$args[$i]] = $args[$i+1];
                }
                // Verify if all keys are not numeric keys
                if(array_filter(array_keys($data), 'is_numeric')){
                    return $this->response->setJSON(['status' => 'failed', "message" => "Numeric keys are not allowed in ajax request"]);
                }
            } else{
                $data = null;
            }
    
        }else{
            $vars = $this->request->getPost();
            extract($vars);
        }
        
        $table_library_name = ucfirst(singular($controller) .'Library');

        // log_message('error', $table_library_name);

    
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


}
