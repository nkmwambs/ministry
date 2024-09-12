<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Services;

class SessionCheck implements FilterInterface
{
/**
 * This method is called before the request is processed by the controller.
 * It checks if the user is authenticated by checking the session.
 * If the user is not authenticated, it redirects to the login page.
 *
 * @param RequestInterface $request The current request object.
 * @param mixed $arguments Additional arguments passed to the filter.
 *
 * @return mixed|ResponseInterface|null Returns a ResponseInterface object if a redirect is needed, null otherwise.
 */
public function before(RequestInterface $request, $arguments = null)
{
    $session = \Config\Services::session();

    // Check if the user is authenticated
    if (!$session->has('logged_in')) {
        // Redirect to the login page if the user is not authenticated
        return redirect()->to('/');
    }else{
        $user_id = session()->get('user_id');
        $uri = service('uri');
        
        
        $router = service('router');

        // Get the current controller and method being called
        $controller = $router->controllerName();
        $method = $router->methodName();

        // Get any route parameters (if any)
        $params = $router->params();

        // You can use the route information as needed
        // For example, logging the route information
        // log_message('error', 'Controller: ' . $controller . ', Method: ' . $method . ', Params: ' . implode(', ', $params));
        // log_message('error', json_encode($router));
    }
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
    }
}
