<?php

use \App\Http\Response;
use \App\Controller\Admin;
use \App\Utils\View;

include __DIR__.'/admin/endereco.php';
include __DIR__.'/admin/cliente.php';

$obRouter->get('/admin', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200,  Admin\Login::getStartDashboard());
  }
]);

$obRouter->get('/admin/login', [
  'middlewares' => [
    'required-admin-logout'
  ],
  function($request) {
    return new Response(200, Admin\Login::getLogin($request));
  }
]);

$obRouter->get('/admin/logout', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, Admin\Login::setLogout($request));
  }
]);

$obRouter->post('/admin/login', [
  'middlewares' => [
    'required-admin-logout'
  ],
  function($request) {
    return new Response(200, Admin\Login::setLogin($request));
  }
]);