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
$curr_user = $session->current_user;

// redirect to login page if no user session
$with_auth = fn($route, $is_api = false) => $curr_user
  ? $route
  : ($is_api
    ? fn() => $response
      ->setStatusCode(Response::HTTP_FORBIDDEN)
      ->setHeader('Content-Type', 'application/json')
      ->setBody('<h1>FORBIDDEN</h1>')
      ->send()
    : fn() => redirect()->to('/auth'));

// redirect to dashboard if there is a user session
$autologin = fn($route) => $curr_user
  ? fn() => redirect()->to('/dashboard')
  : $route;

// only allow admin access
$only_admin = fn($route) => $curr_user
  ? ($curr_user['level'] == 1
    ? $route
    : fn() => redirect()->to('/auth'))
  : fn() => redirect()->to('/auth');

$routes->get('/', fn() => redirect()->to('/auth'));

$routes->get('/auth', $autologin('Auth::index'));
$routes->get('/auth/login', $autologin('Auth::login'));
$routes->get('/auth/logout', 'Auth::logout');

$routes->get('/dashboard', $with_auth('Dashboard::index'));

$routes->get('/user', $only_admin($with_auth('User::index')));
$routes->get('/user/tambah', $only_admin($with_auth('User::form')));
$routes->post('/user/tambah', $only_admin($with_auth('User::save')));
$routes->post(
  '/user/tambah/(:any)',
  $only_admin($with_auth('User::save/$1'))
);
$routes->post('/user/edit/(:any)', $only_admin($with_auth('User::form/$1')));

$routes->get('/supplier', $with_auth('Supplier::index'));
$routes->get('/supplier/tambah', $with_auth('Supplier::form'));
$routes->post('/supplier/tambah', $with_auth('Supplier::save'));
$routes->post('/supplier/tambah/(:any)', $with_auth('Supplier::save/$1'));
$routes->delete('/supplier/hapus/(:any)', $with_auth('Supplier::hapus'));
$routes->post('/supplier/edit/(:any)', $with_auth('Supplier::form/$1'));
$routes->get('/supplier/export', $with_auth('Supplier::export'));

$routes->get('/barang', $with_auth('Barang::index'));
$routes->get('/barang/tambah', $with_auth('Barang::form'));
$routes->post('/barang/tambah/(:any)', $with_auth('Barang::save/$1'));
$routes->post('/barang/tambah', $with_auth('Barang::save'));
// this should be DELETE, but HTML form doesn't have that..
$routes->post('/barang/hapus/(:any)', $with_auth('Barang::hapus/$1'));
$routes->post('/barang/edit/(:any)', $with_auth('Barang::form/$1'));
$routes->get('/barang/export', $with_auth('Barang::export'));

$routes->get('/barang-masuk', $with_auth('BarangMasuk::index'));
$routes->get('/barang-masuk/tambah', $with_auth('BarangMasuk::tambah'));
$routes->post(
  '/barang-masuk/tambah/(:any)',
  $with_auth('BarangMasuk::save/$1')
);
$routes->post('/barang-masuk/tambah', $with_auth('BarangMasuk::save'));
// this should be DELETE, but HTML form doesn't have that..
$routes->post(
  '/barang-masuk/hapus/(:any)',
  $with_auth('BarangMasuk::hapus/$1')
);
$routes->get('/barang-masuk/export', $with_auth('BarangMasuk::export'));

$routes->get('/barang-keluar', $with_auth('BarangKeluar::index'));
$routes->get('/barang-keluar/tambah', $with_auth('BarangKeluar::tambah'));
$routes->post(
  '/barang-keluar/tambah/(:any)',
  $with_auth('BarangKeluar::save/$1')
);
$routes->post('/barang-keluar/tambah', $with_auth('BarangKeluar::save'));
// this should be DELETE, but HTML form doesn't have that..
$routes->post(
  '/barang-keluar/hapus/(:any)',
  $with_auth('BarangKeluar::hapus/$1')
);
$routes->get('/barang-keluar/export', $with_auth('BarangKeluar::export'));

$routes->get('/stok', $with_auth('Stok::index', true));
$routes->get('/stok/report', $with_auth('Stok::report', true));

$routes->get('/api/user', $only_admin($with_auth('User::get_all')));
$routes->get('/api/supplier', $with_auth('Supplier::get_all', true));
$routes->get('/api/stok', $with_auth('Stok::get_all', true));
$routes->get('/api/barang', $with_auth('Barang::get_all', true));
$routes->get('/api/barang-masuk', $with_auth('BarangMasuk::get_all', true));
$routes->get('/api/barang-keluar', $with_auth('BarangKeluar::get_all', true));

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
