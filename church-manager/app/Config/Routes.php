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

$routes->get('denominations', 'Denomination::index');
$routes->get('denominations/add', 'Denomination::add');
$routes->get('denominations/view/(:segment)', 'Denomination::view/$1');
$routes->get('denominations/edit/(:segment)', 'Denomination::edit/$1');
$routes->post('denominations/update', 'Denomination::update');
$routes->post('denominations/save', 'Denomination::post');

$routes->get('users', 'User::index');
$routes->get('users/add', 'User::add');
$routes->get('users/view/(:segment)', 'User::view/$1');
$routes->get('users/edit/(:segment)', 'User::edit/$1');
$routes->post('users/update', 'User::update');
$routes->post('users/save', 'User::post');

$routes->get('hierarchies', 'Hierarchy::index');
$routes->get('hierarchies/(:segment)', 'Hierarchy::index/$1');
$routes->get('hierarchies/add', 'Hierarchy::add');
$routes->get('hierarchies/view/(:segment)', 'Hierarchy::view/$1');
$routes->get('hierarchies/edit/(:segment)', 'Hierarchy::edit/$1');
$routes->post('hierarchies/update', 'Hierarchy::update');
$routes->post('hierarchies/save', 'Hierarchy::post');

$routes->get('assemblies', 'Assembly::index');
$routes->get('assemblies/(:segment)', 'Assembly::index/$1');
$routes->get('assemblies/add', 'Assembly::add');
$routes->get('assemblies/view/(:segment)', 'Assembly::view/$1');
$routes->get('assemblies/edit/(:segment)', 'Assembly::edit/$1');
$routes->post('assemblies/update', 'Assembly::update');
$routes->post('assemblies/save', 'Assembly::post');

$routes->get('events', 'Event::index');
$routes->get('events/(:segment)', 'Event::index/$1');
$routes->get('events/add', 'Event::add');
$routes->get('events/view/(:segment)', 'Event::view/$1');
$routes->get('events/edit/(:segment)', 'Event::edit/$1');
$routes->post('events/update', 'Event::update');
$routes->post('events/save', 'Event::post');

$routes->get('entities', 'Entity::index');
$routes->get('entities/add', 'Entity::add');
$routes->get('entities/view/(:segment)', 'Entity::view/$1');
$routes->get('entities/edit/(:segment)', 'Entity::edit/$1');
$routes->post('entities/update', 'Entity::update');
$routes->post('entities/save', 'Entity::post');

$routes->get('ministers', 'Minister::index');
$routes->get('churches', 'Church::index');
$routes->get('events', 'Event::index');


