<?php

use CodeIgniter\Router\RouteCollection;

helper('inflector');

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->post('/validate', 'Login::userValidate');

$featureModel = new \App\Models\FeaturesModel();
$features = $featureModel->findAll();

foreach ($features as $featureObj) {
    $feature = $featureObj['name'];
    $ucfirst = ucfirst($feature);
    $group = plural($feature);
    // log_message('error', json_encode($group));
    $routes->group($group, function ($routes) use ($ucfirst) {
            $routes->get('/', "$ucfirst::index");
            $routes->get('(:segment)', "$ucfirst::index/$1");
            $routes->get('add', "$ucfirst::add");
            $routes->get('view/(:segment)', "$ucfirst::view/$1");
            $routes->get('edit/(:segment)', "$ucfirst::edit/$1");
            $routes->post('update', "$ucfirst::update");
            $routes->post('save', "$ucfirst::post");
            $routes->get('modal/(:segment)/(:segment)', "$ucfirst::modal/$1/$2");
            $routes->get('modal/(:segment)/(:segment)/(:segment)', "$ucfirst::modal/$1/$2/$3");
    });
}

$routes->get('entities/items/(:segment)/(:segment)', "Entity::getParentEntitiesByDenomination/$1/$2");
$routes->get('hierarchies/denomination/(:segment)', "Hierarchy::getHierarchiesByDenominationId/$1");

