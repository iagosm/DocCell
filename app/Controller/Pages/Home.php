<?php

namespace App\Controller\Pages;
use \App\Utils\View;

class Home extends Page{

  // responsavel para retornar o conteudo (view) da nossa home
  public static function getHome() {
    // VIEW da Home
    $organization = new \App\Model\Entity\Organization();
    $conteudo = View::render('pages/home', [
      'name' =>  $organization->name, 
    ]);
    return parent::getPage('Home >', $conteudo);
  }
}