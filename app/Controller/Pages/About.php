<?php

namespace App\Controller\Pages;
use \App\Utils\View;

class About extends Page{

  // responsavel para retornar o conteudo (view) da nossa sobre
  public static function getAbout() {
    // VIEW da Home
    $organization = new \App\Model\Entity\Organization();
    $conteudo = View::render('pages/about', [
      'name' =>  $organization->name, 
      'apelido' => $organization->apelido,
      'site' => $organization->site,
      'description' => $organization->description
    ]);
    return parent::getPage('SOBRE > IAGO', $conteudo);
  }
}