<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimoney;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page{

  private static function getTestimonyItems($request, &$obPagination) { // obter renderização dos itens de depoimentos
    $itens = '';
    // Quantidade total de registros
    $quantidadeTotal = EntityTestimoney::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
    
    // pagina atual 
    $queryParams = $request->getQueryParams();
    $paginaAtual = $queryParams['page'] ?? 1;

    // instancia de paginação
    $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

    $results = EntityTestimoney::getTestimonies(null, 'id DESC', $obPagination->getLimit());
    // Renderiza o item
    while($obtestMony = $results->fetchObject(EntityTestimoney::class)) {
      $itens .= View::render('pages/testimony/item', [
        'nome' => $obtestMony->nome,
        'mensagem' => $obtestMony->mensagem,
        'data' => date('d/m/Y H:i:s', strtotime($obtestMony->data)),
      ]);
    }
    return $itens;
  }

  // responsavel para retornar o conteudo (view) de depoimentos
  public static function getTestimonies($request) {
    
    // VIEW de depoimentos
    $conteudo = View::render('pages/testimonies', [
     'itens' => self::getTestimonyItems($request, $obPagination),
     'pagination' => parent::getPagination($request, $obPagination)
    ]);
    return parent::getPage('Depoimentos > IAGO', $conteudo);
  }

  public static function insertTestmony($request) { // responsavel por cadastrar depoimento
    $postVars = $request->getPostVars();

    $obTestimony = new EntityTestimoney;
    $obTestimony->nome = $postVars['nome'] ?? '';
    $obTestimony->mensagem = $postVars['mensagem'] ?? '';
    $obTestimony->cadastrar();
    // retorna a pagina de listagem de depoimentos
    return self::getTestimonies($request);
  }
}