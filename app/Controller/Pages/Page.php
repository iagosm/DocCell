<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page {

  private static function getHeader() {
    return View::render('pages/header');
  }

  private static function getFooter() {
    return View::render('pages/footer');
  }

  public static function getPagination($request, $obPagination) {
    $pages = $obPagination->getPages();

    // Verifica a pagina de pages
    if(count($pages) <= 1) return '';

    $links = '';

    // url atual do projeto
    

    // URl atual sem gets
    $url = $request->getRouter()->getCurrentUrl();
    // GET
    $queryParams = $request->getQueryParams();
    // renderiza os links
    foreach($pages as $page) {
      // altera a paigna
      $queryParams['page'] = $page['page'];
      // link 
      $link = $url.'?'.http_build_query($queryParams);

      // view 
      $links .= View::render('pages/pagination/link', [
        'page' => $page['page'],
        'link' => $link,
        'active' => $page['current'] ? 'active' : '',
      ]);
    }

    return View::render('pages/pagination/box', [
      'links' => $links,
    ]);
  }

  // responsavel por retornar o conteudo da (view) generica
  public static function getPage($title, $content) { 
    
    return View::render('pages/page', [
      'header' => self::getHeader(),
      'title' => $title,
      'content' => $content,
      'footer' => self::getFooter(),
    ]);
  }
}