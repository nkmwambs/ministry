<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/logout', 'Login::logout');
// $routes->get('/home', 'Home::index');
$routes->post('/validate', 'Login::userValidate');

$routes->get('/dashboards', 'Dashboard::index');

$routes->get('/denominations', 'Denomination::index');
$routes->get('/denominations/add', 'Denomination::add');
$routes->get('/denominations/view/(:segment)', 'Denomination::view/$1');
$routes->get('/denominations/edit/(:segment)', 'Denomination::edit/$1');
$routes->post('/denominations', 'Denomination::post');
$routes->post('/denominations/update/(:segment)', 'Denomination::update/$1');

$routes->get('/ministers', 'Minister::index');
$routes->get('/churches', 'Church::index');
$routes->get('/events', 'Event::index');


