<?php 

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Endereco {
  
  public function add() {
    $database = new Database();
    $conn = $database->connection;
    $now = date("Y-m-d H:i:s");
    $sql = "INSERT INTO endereco
    (cep, endereco, cidade, uf, bairro, ativo, created, updated) 
    VALUES 
    ('41612060','Princesa Isabel','Salvador','BA','Cajiviz','S','$now','$now')";
    $sql = $conn->query($sql);
    if($sql->rowCount() > 0) {
      $id = $conn->lastInsertId();
      return $id;
    }
    return 0;
  }

  public function edit() {
    $database = new Database();
    $conn = $database->connection;
    $now = date("Y-m-d H:i:s");
    $sql = "INSERT INTO endereco
    (cep, endereco, cidade, uf, bairro, ativo, created, updated) 
    VALUES 
    ('41612060','Princesa Isabel','Salvador','BA','Cajiviz','S','$now','$now')";
    $sql = $conn->query($sql);
    if($sql->rowCount() > 0) {
      $id = $conn->lastInsertId();
      return $id;
    }
    return 0;
  }

  public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*') {
    return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
  }

  public static function getTestimonyById($where = null, $order = null, $limit = null, $fields = '*') {
    return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
  }
}