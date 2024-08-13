<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/home', 'Home::index');
$routes->post('/validate', 'Login::userValidate');
