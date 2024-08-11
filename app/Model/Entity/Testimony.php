<?php 

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony {

  public $id;
  public $nome;
  public $mensagem;
  public $data;

  public function cadastrar() { // cadastrar instancia atual no banco
    $this->data = date('Y-m-d H:i:s');
    // Insere o depoimento de dados
    $this->id = (new Database('depoimentos'))->insert([
      'nome' => $this->nome,
      'mensagem' => $this->mensagem,
      'data' => $this->data,
    ]);
    return true;
  }

  public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*') {
    return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
  }

  public static function getTestimonyById($where = null, $order = null, $limit = null, $fields = '*') {
    return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
  }
}