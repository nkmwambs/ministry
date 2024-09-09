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
    $routes->group($group, function ($routes) use ($ucfirst) {
            $routes->get('/', "$ucfirst::index");
            $routes->get('(:segment)', "$ucfirst::index/$1");
            $routes->get('add', "$ucfirst::add");
            $routes->get('view/(:segment)', "$ucfirst::view/$1");
            $routes->get('view/(:segment)/(:segment)', "$ucfirst::view/$1");
            $routes->get('edit/(:segment)', "$ucfirst::edit/$1");
            $routes->get('delete/(:segment)', "$ucfirst::delete/$1");
            $routes->post('update', "$ucfirst::update");
            $routes->post('save', "$ucfirst::post");
            $routes->get('modal/(:segment)/(:segment)', "$ucfirst::modal/$1/$2");
            $routes->get('modal/(:segment)/(:segment)/(:segment)', "$ucfirst::modal/$1/$2/$3");
    });
}

$routes->get('entities/items/(:segment)/(:segment)', "Entity::getParentEntitiesByDenomination/$1/$2");
$routes->get('entities/lowestEntities/(:segment)', "Entity::getDenominationLowestEntities/$1");
$routes->get('entities/hierarchy/(:segment)', "Entity::getEntitiesByHierarchyId/$1");
$routes->get('assemblies/denomination/(:segment)', "Assembly::getAssembliesByDenominationId/$1");
$routes->get('hierarchies/denomination/(:segment)', "Hierarchy::getHierarchiesByDenominationId/$1");
$routes->get('hierarchies/all_denomination/(:segment)', "Hierarchy::getAllHierarchiesByDenominationId/$1");
$routes->get('participants/event/(:segment)', 'Participant::getParticipantsByEventId/$1');
$routes->get('settings', 'Setting::list');
$routes->get('roles/get_default_role/(:segment)', 'Role::getDefaultRole/$1');
$routes->get('features/get_allowable_permission_labels/(:segment)', 'Feature::getAllowablePermissionLabels/$1');
$routes->post('permissions/update_permission', 'Permission::updatePermission/');
// $routes->get('/user/getHierarchiesWithEntities', 'User::getHierarchiesWithEntities');
$routes->post('users/store', 'User::store');

