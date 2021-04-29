<?php

namespace Config;

use CodeIgniter\HTTP\Response;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
  require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get("/", "Dashboard::index");
$session = session();
$response = service('response');

// redirect to login page if no user session
$with_auth = fn($route, $is_api = false) => $session->current_user
  ? $route
  : ($is_api
    ? fn() => $response
      ->setStatusCode(Response::HTTP_FORBIDDEN)
      ->setHeader('Content-Type', 'application/json')
      ->setBody('<h1>FORBIDDEN</h1>')
      ->send()
    : fn() => redirect()->to('/auth'));

$routes->get('/', fn() => redirect()->to('/auth'));

$routes->get('/auth', 'Auth::index');
$routes->get('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->get('/dashboard', $with_auth('Dashboard::index'));

$routes->get('/supplier', $with_auth('Supplier::index'));
$routes->get('/supplier/tambah', $with_auth('Supplier::form'));
$routes->post('/supplier/tambah', $with_auth('Supplier::save'));
$routes->post('/supplier/tambah/(:alphanum)', $with_auth('Supplier::save/$1'));
$routes->delete('/supplier/hapus/(:alphanum)', $with_auth('Supplier::hapus'));

$routes->get('/barang', $with_auth('Barang::index'));
$routes->get('/barang/masuk', $with_auth('BarangMasuk::index'));
$routes->get('/barang/tambah', $with_auth('Barang::tambah'));
$routes->post('/barang/tambah/(:alphanum)', $with_auth('Barang::save/$1'));
$routes->post('/barang/tambah', $with_auth('Barang::save'));
$routes->delete('/barang/hapus', $with_auth('Barang::hapus'));
$routes->get('/barang/edit', $with_auth('Barang::edit'));

$routes->get('/api/supplier', $with_auth('Supplier::getAll', true));
$routes->get('/api/barang-masuk', $with_auth('BarangMasuk::getAll', true));
$routes->get('/api/barang', $with_auth('Barang::getAll', true));

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
