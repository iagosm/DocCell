<?php

namespace App\Controller\Admin;

use \App\Utils\View;

class Endereco extends Page{

  public static function endereco() {

    $conteudo = View::render('admin/endereco', [
      'title' =>  'oloa', 
      'apelido' => 'asada',
      'site' => 'adsad',
    ]);
    return parent::getPage('Dashboard', $conteudo);
  }

  public static function add($dados) {
    $missingColumns = self::getExistColumns(['cep', 'endereco', 'cidade', 'uf', 'bairro', 'ativo']);
    if($missingColumns) {
      $endereco = new \App\Model\Entity\Endereco();
      $a = $endereco->add($dados);
      var_dump($a);exit;
    } else {
      $resultado = 'Há campos pendentes, preencha todos novamente';
    }
    return $resultado;
  }

  public static function getExistColumns($dados, $type = 'add') {
    
    $columns = ['cep', 'endereco', 'cidade', 'uf', 'bairro', 'ativo'];
    if($type == 'edit') {
      $columns[] = 'id';
    }
    $missingColumns = array_diff($columns, $dados);
    // Se houver colunas faltando, retorna false; caso contrário, retorna true
    return empty($missingColumns);
  }
}