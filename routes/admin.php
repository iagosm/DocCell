<?php

use \App\Http\Response;
use \App\Controller\Admin;
use \App\Utils\View;

$obRouter->get('/admin', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200,  Admin\Login::getStartDashboard());
  }
]);

$obRouter->get('/admin/endereco', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200,  Admin\Endereco::endereco());
  }
]);

$obRouter->get('/admin/enderecos', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200,  Admin\Endereco::getAllEnderecos(), 'application/json');
  }
]);

// Cadastrar Endereço
$obRouter->post('/admin/endereco/add', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    $postVars = $request->getPostVars();
    return new Response(200,  Admin\Endereco::add($postVars), 'application/json');
  }
]);

$obRouter->get('/admin/endereco/get/{id}', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($id) {
    return new Response(200, Admin\Endereco::getEndereco($id), 'application/json');
}]);

$obRouter->post('/admin/endereco/{id}/edit', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request, $id) {
    $postVars = $request->getPostVars();
    return new Response(200, Admin\Endereco::edit($postVars, $id));
}]);

$obRouter->post('/admin/endereco/{id}/del', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($id) {
    return new Response(200, Admin\Endereco::del($id), 'application/json');
}]);

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