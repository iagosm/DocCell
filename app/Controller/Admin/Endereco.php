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
    // $scripts = View::findScript(['endereco']);
    return parent::getPage('Dashboard', $conteudo);
  }

  public static function getEndereco($id) {
    $endereco = new \App\Model\Entity\Endereco();
    $resultado = $endereco->getEndereco($id);
    return $resultado;
  }

  public static function getAllEnderecos() {
    $endereco = new \App\Model\Entity\Endereco();
    $resultado = $endereco->getAllEnderecos();
    if(!empty($resultado)) {
      $array = array();
      foreach($resultado as $endereco) {
        $array[] = [
          $endereco['idendereco'], $endereco['cep'], $endereco['endereco'],
          $endereco['cidade'].'/'.$endereco['uf'], $endereco['bairro'], 
          '<div class="d-flex gap-2">
            <button class="button-action up" data-action="up" data-id="'.$endereco['idendereco'].'">
              <i class="fa-solid fa-pencil"></i>
            </button>
            <button class="button-action del" data-action="del" data-id="'.$endereco['idendereco'].'">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>'
        ];
      }
      $resultado = $array;
    }
    return $resultado;
  }

  public static function add($dados) {
    $missingColumns = self::getExistColumns(['cep', 'endereco', 'cidade', 'uf', 'bairro', 'ativo']);
    if($missingColumns && !empty($dados)) {
      $endereco = new \App\Model\Entity\Endereco();
      $resultado = $endereco->add($dados);
    } else {
      $resultado = 'Há campos pendentes, preencha todos novamente';
    }
    return $resultado;
  }
  public static function edit($dados, $id) {
    $missingColumns = self::getExistColumns(['cep', 'endereco', 'cidade', 'uf', 'bairro', 'ativo']);
    if($missingColumns && !empty($dados)) {
      $endereco = new \App\Model\Entity\Endereco();
      $a = $endereco->edit($id, $dados);
      var_dump($a);exit;
    } else {
      $resultado = 'Há campos pendentes, preencha todos novamente';
    }
    return $resultado;
  }

  public static function del($id) {
    $endereco = new \App\Model\Entity\Endereco();
    return $endereco->delete($id);
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