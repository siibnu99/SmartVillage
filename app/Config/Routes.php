<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
$request = Services::request();
$request->adminUrl = getenv("app.adminurl");
helper(['baseapp', 'menu', 'user', 'filesystem']);
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->group("api", function ($routes) {
    $routes->group("auth", function ($routes) {
        $routes->post('login', 'ApiAuth::login');
        $routes->post('register', 'ApiAuth::register');
        $routes->get('user', 'ApiAuth::user', ['filter' => 'jwt']);
    });
    $routes->group("user", function ($routes) {
        $routes->get('/', 'ApiUser::getOnce', ['filter' => 'jwt']);
    });
    $routes->group("userdetail", function ($routes) {
        $routes->get('/', 'ApiUserDetail::getOnce', ['filter' => 'jwt']);
        $routes->post('/', 'ApiUserDetail::update', ['filter' => 'jwt']);
        $routes->post('picture', 'ApiUserDetail::updateWithImage', ['filter' => 'jwt']);
    });
    $routes->group("surat", function ($routes) {
        $routes->post('ktp', 'ApiSurat::uploadKTP', ['filter' => 'jwt']);
        $routes->post('all', 'ApiSurat::all', ['filter' => 'jwt']);
        $routes->post('allpicture', 'ApiSurat::allpicture', ['filter' => 'jwt']);
        $routes->post('getall', 'ApiSurat::getAll', ['filter' => 'jwt']);
        $routes->get('getnotifcount', 'ApiSurat::getnotifcount', ['filter' => 'jwt']);
        $routes->post('setnotif', 'ApiSurat::setnotif', ['filter' => 'jwt']);
    });
});
$routes->group($request->adminUrl, function ($routes) {
    $routes->group('auth', function ($routes) {
        $routes->get('/', 'Auth::index', ['filter' => 'noauth']);
        $routes->post('/', 'Auth::loginAction', ['filter' => 'noauth']);
        $routes->get('register', 'Auth::register', ['filter' => 'noauth']);
        $routes->post('register', 'Auth::registerAction', ['filter' => 'noauth']);
        $routes->get('logout', 'Auth::logout');
    });
    $routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
        $routes->get('/', 'Dashboard::index');
    });
    $routes->group('user', ['filter' => 'auth'], function ($routes) {
        $routes->get('', 'User::index');
        $routes->get('(:num)', 'User::index/$1');
        $routes->get('add', 'User::add');
        $routes->post('add', 'User::addAttempt');
        $routes->get('edit/(:segment)', 'User::edit/$1');
        $routes->post('edit/(:segment)', 'User::editAttempt');
        $routes->get('cpassword/(:segment)', 'User::password/$1');
        $routes->post('cpassword/(:segment)', 'User::passwordAttempt');
        $routes->post('delete', 'User::deleteAttempt');
        $routes->post('active', 'User::toggleActiveAttempt');
        $routes->post('listdata', 'User::listdata');
        $routes->post('listdata/(:segment)', 'User::listdata/$1');
    });
    $routes->group('surat', ['filter' => 'auth'], function ($routes) {
        $routes->get('', 'Surat::index');
        $routes->get('(:num)', 'Surat::index/$1');
        $routes->get('detail/(:segment)', 'Surat::detail/$1');
        $routes->get('change', 'Surat::change');
        $routes->post('listdata', 'Surat::listdata');
        $routes->post('listdata/(:segment)', 'Surat::listdata/$1');
    });
    $routes->group('log', ['filter' => 'auth'], function ($routes) {
        $routes->get('/', 'Log::index');
        $routes->get('(:segment)', 'Log::detail/$1');
    });
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
