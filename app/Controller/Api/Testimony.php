<?php

namespace App\Controller\Api;

use App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Api {

  private static function getTestimonyItems($request, &$obPagination) { // obter renderização dos itens de depoimentos
    $itens = [];
    // Quantidade total de registros
    $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
    
    // pagina atual 
    $queryParams = $request->getQueryParams();
    $paginaAtual = $queryParams['page'] ?? 1;

    // instancia de paginação
    $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

    $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());
    // Renderiza o item
    while($obtestMony = $results->fetchObject(EntityTestimony::class)) {
      $itens[] = [
        'id' => (int) $obtestMony->id,
        'nome' => $obtestMony->nome,
        'mensagem' => $obtestMony->mensagem,
        'data' => date('d/m/Y H:i:s', strtotime($obtestMony->data)),
      ];
    }
    return $itens;
  }

  public static function getTestimonies($request) {

    return [
      'depoimentos' => self::getTestimonyItems($request, $obPagination),
      'pagination' => parent::getPagination($request, $obPagination)
    ];
  }

  // detalhes unicos de um depoimento
  public static function getTestimony($request, $id) {

    if(!is_numeric($id)) {
      throw new \Exception("o id ".$id." não é válido", 400);
    }
    $obTestimony = EntityTestimony::getTestimonyById("id = '$id'", null, null);
    if(!$obTestimony instanceof EntityTestimony) {
      throw new \Exception("o depoimento ".$id." não foi encontrado", 404);
    }
    return [
      'id' => (int) $obTestimony->id,
      'nome' => $obTestimony->nome,
      'mensagem' => $obTestimony->mensagem,
      'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data)),
    ];
  }
}