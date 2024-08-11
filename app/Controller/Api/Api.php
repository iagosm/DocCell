<?php

namespace App\Controller\Api;

class Api {

  public static function getDetails($request) {
    
    return [
      'nome' => 'Dashboard',
      'versao' => 'v1.0.0',
      'autor' => 'Iago Sousa',
    ];
  }

  protected static function getPagination($request, $obPaignation) {
    $queryParams = $request->getQueryParams();
    $pages = $obPaignation->getPages();
    return [
      'paginaAtual' => isset($queryParams['page']) ? (int) $queryParams['page'] : 1,
      'quantidadePaginas' => !empty($pages) ? count($pages) : 1,
    ];
  }
}