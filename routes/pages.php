<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/', [
  function() {
    return new Response(200, Pages\Home::getHome());
  }
]);

$obRouter->get('/sobre', [
  function() {
    return new Response(200, Pages\About::getAbout());
  }
]);

$obRouter->get('/depoimentos', [
  function($request) {
    return new Response(200, Pages\Testimony::getTestimonies($request));
  }
]);
// rota de depoimentos insert
$obRouter->post('/depoimentos', [
  function($request) {
    return new Response(200, Pages\Testimony::insertTestmony($request));
  }
]);



// $obRouter->get('/pagina/{idPagina}/{acao}', [
//   function($idPagina, $acao) {
//     return new Response(200, 'Página '. $idPagina. ' - '.$acao);
//   }
// ]);