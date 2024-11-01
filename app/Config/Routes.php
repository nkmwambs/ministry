<?php

use CodeIgniter\Router\RouteCollection;

helper('inflector');

// /**
//  * @var RouteCollection $routes
//  */

$routes->group("", ['namespace' => 'App\Controllers\Admin'],function($routes){
    $featureModel = new \App\Models\FeaturesModel();
    $features = $featureModel->findAll();
    
    foreach ($features as $featureObj) {
        $feature = $featureObj['name'];
        $ucfirst = ucfirst($feature);
        $group = plural($feature);
        $routes->group($group, function ($routes) use ($ucfirst, $group) {
                $routes->get('list', "$ucfirst::index");
                $routes->get('list/(:segment)', "$ucfirst::index/$1");
                $routes->get('add', "$ucfirst::add");
                $routes->get('view/(:segment)', "$ucfirst::view/$1");
                $routes->get('view/(:segment)/(:segment)', "$ucfirst::view/$1");
                $routes->get('edit/(:segment)', "$ucfirst::edit/$1");
                $routes->get('delete/(:segment)', "$ucfirst::delete/$1");
                $routes->post('update', "$ucfirst::update");
                $routes->post('save', "$ucfirst::post");
                $routes->get('modal/(:segment)/(:segment)', "$ucfirst::modal/$1/$2");
                $routes->get('modal/(:segment)/(:segment)/(:segment)', "$ucfirst::modal/$1/$2/$3");
                $routes->post('getFields/(:segment)/(:segment)', "$ucfirst::getBulkActionFields/$1/$2");
                $routes->post('bulk_edit', "$ucfirst::bulkEdit");
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
    
    $routes->post('users/profile/account/save', "User::updatePublicInfo");
    $routes->post('users/profile/account/update_public_info', "User::updatePublicInfo");
    $routes->post('users/profile/account/update_private_info', "User::updatePrivateInfo");
    
    $routes->group('users/profile', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('account/(:segment)', 'User::getAccount/$1');
        $routes->get('account', 'User::editAccount');
        $routes->post('account/update_public_info', 'User::updatePrivateInfo');
        $routes->post('account/update_private_info', 'User::updatePrivateInfo');
        $routes->post('account/save', 'User::postPrivateInfo');
        $routes->get('password_reset/(:segment)', "User::passwordReset/$1");
        $routes->post('verify_password', "User::passwordVerify");
        $routes->get('email_notifications/(:segment)', "User::emailNotifications/$1");
        $routes->get('pending_tasks/(:segment)', 'User::pendingTasks/$1');
        $routes->post('save_task', 'Task::saveTask');
        $routes->get('privacy/(:segment)', "User::privacy/$1");
        $routes->get('your_data/(:segment)', "User::yourData/$1");
        $routes->get('downloadUserData/(:segment)', 'User::downloadUserData/$1');
        $routes->get('deleteAccount/(:segment)', 'User::deleteAccount/$1');
        $routes->get('delete_account/(:segment)', "User::deleteAccount/$1");
    });
    
    $routes->post('users/update/public/', 'User::updatePublicInfo'); 
    $routes->post('users/update/private/', 'User::updatePrivateInfo');
    
    $routes->post('/tasks/updateStatus', 'Task::updateStatus');
    
    $routes->post('denominations/fetchDenominations', 'Denomination::fetchDenominations');
    $routes->post('ministers/fetchMinisters', 'Minister::fetchMinisters');
    $routes->post('ministers/fetchMinisters', 'Minister::fetchMinisters');
    $routes->post('assemblies/fetchAssemblies', 'Assembly::fetchAssemblies');
    $routes->post('events/fetchEvents', 'Event::fetchEvents');
    $routes->post('users/fetchUsers', 'User::fetchUsers');
    $routes->post('departments/fetchDepartments', 'Department::fetchDepartments');
    $routes->post('reports/fetchReports', 'Report::fetchReports');
    $routes->post('assemblies/fetchAssemblies', 'Assembly::fetchAssemblies');
    $routes->post('members/fetchMembers/(:num)','Member::fetchMembers/$1');
    
    $routes->group('reports', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('list/(:segment)', 'Report::list/$1');
    });
    
    $routes->get('reports/details/(:any)', 'Report::viewDetails/$1');
    $routes->post('reports/save_report', 'Report::saveReport');
    
});


$routes->group('ajax', static function($routes){
    $routes->post('/','WebController::ajax');
    $routes->get('(:segment)/(:segment)/(:any)','WebController::ajax/$1/$2/$3');
});


$routes->group("church", ['namespace' => 'App\Controllers\Church'],function($routes){
    $featureModel = new \App\Models\FeaturesModel();
    $features = $featureModel->findAll();
    
    foreach ($features as $featureObj) {
        $feature = $featureObj['name'];
        $ucfirst = ucfirst($feature);
        $group = plural($feature);
        $routes->group($group, function ($routes) use ($ucfirst, $group) {
                $routes->get('list', "$ucfirst::index");
                $routes->get('list/(:segment)', "$ucfirst::index/$1");
                $routes->get('add', "$ucfirst::add");
                $routes->get('view/(:segment)', "$ucfirst::view/$1");
                $routes->get('view/(:segment)/(:segment)', "$ucfirst::view/$1");
                $routes->get('edit/(:segment)', "$ucfirst::edit/$1");
                $routes->get('delete/(:segment)', "$ucfirst::delete/$1");
                $routes->post('update', "$ucfirst::update");
                $routes->post('save', "$ucfirst::post");
                $routes->get('modal/(:segment)/(:segment)', "$ucfirst::modal/$1/$2");
                $routes->get('modal/(:segment)/(:segment)/(:segment)', "$ucfirst::modal/$1/$2/$3");
                $routes->post('getFields/(:segment)/(:segment)', "$ucfirst::getBulkActionFields/$1/$2");
                $routes->post('bulk_edit', "$ucfirst::bulkEdit");
        });
    }
});

                     
$routes->get('logout', 'Login::logout');
$routes->get('/', '\CodeIgniter\Shield\Controllers\LoginController::loginView');
$routes->get('home','Home::index');
service('auth')->routes($routes);