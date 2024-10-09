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
    $routes->group($group, function ($routes) use ($ucfirst, $group) {
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

$routes->post('users/profile/account/save', "User::updatePublicInfo");
$routes->post('users/profile/account/update_public_info', "User::updatePublicInfo");
$routes->post('users/profile/account/update_private_info', "User::updatePrivateInfo");

$routes->group('users/profile', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('account/(:segment)', 'User::getAccount/$1');
    $routes->get('account', 'User::editAccount');      // Display the account edit form
    $routes->post('account/update_public_info', 'User::updatePrivateInfo');  // Handle the account update form submission
    $routes->post('account/update_private_info', 'User::updatePrivateInfo');
    $routes->post('account/save', 'User::postPrivateInfo');
    $routes->get('password_reset/(:segment)', "User::passwordReset/$1");
    $routes->post('verify_password', "User::passwordVerify");
    $routes->get('email_notifications/(:segment)', "User::emailNotifications/$1");
    $routes->get('pending_tasks/(:segment)', 'User::pendingTasks/$1');
    $routes->post('save_task', 'Task::saveTask');
    $routes->post('update_task', 'Task::updateTask');
    $routes->post('update_task_status/', 'Task::updateTaskStatus');
    $routes->get('privacy/(:segment)', "User::privacy/$1");
    $routes->get('your_data/(:segment)', "User::yourData/$1");
    $routes->get('delete_account/(:segment)', "User::deleteAccount/$1");
});

$routes->post('users/view/(:segment)/pending_tasks/save-task', 'Task::saveTask/$1');
// $routes->post('update_task_status/', 'Task::updateTaskStatus');

$routes->post('denominations/fetchDenominations', 'Denomination::fetchDenominations');
$routes->post('ministers/fetchMinisters', 'Minister::fetchMinisters');
$routes->post('assemblies/fetchAssemblies', 'Assembly::fetchAssemblies');
$routes->post('events/fetchEvents', 'Event::fetchEvents');
$routes->post('ministers/fetchMinisters', 'Minister::fetchMinisters');
$routes->post('assemblies/fetchAssemblies', 'Assembly::fetchAssemblies');
$routes->post('members/fetchMembers/(:num)','Member::fetchMembers/$1');

$routes->group('reports', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('section_a/(:segment)', 'Report::sectionA/$1');
    $routes->get('section_b/(:segment)', 'Report::sectionB/$1');
    $routes->get('section_c/(:segment)', 'Report::sectionC/$1');
    $routes->get('section_d/(:segment)', 'Report::sectionD/$1');
    $routes->get('edit', "Report::editReport");
    $routes->get('load_section/(:seg)', 'Report::load_section/$1');
});

$routes->get('reports/section_a', 'Report::section_a');
$routes->get('reports/section_b', 'Report::section_b');
// Add more routes for other sections as needed
