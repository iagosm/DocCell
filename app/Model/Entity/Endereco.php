<?php 

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Endereco {
  
  public function getAllEnderecos() {
    $database = new Database();
    $conn = $database->connection;
    $sql = "SELECT * FROM endereco";
    $sql = $conn->query($sql);
    if($sql->rowCount() > 0) {
      return $sql->fetchAll();
    }
    return array();
  }

  public function getEndereco($id) {
    $id = intval($id);
    $database = new Database();
    $conn = $database->connection;
    $sql = "SELECT * FROM endereco 
    WHERE idendereco=$id";
    $sql = $conn->query($sql);
    if($sql->rowCount() > 0) {
      return $sql->fetch(\PDO::FETCH_ASSOC);
    }
    return array();
  }

  public function add($dados) {
    $database = new Database();
    $conn = $database->connection;
    $sql = "INSERT INTO endereco
    (cep, endereco, cidade, uf, bairro, ativo, created, updated) 
    VALUES 
    (:cep, :endereco, :cidade, :uf, :bairro, :ativo, :created, :updated)";
    $sql = $conn->prepare($sql);
    $sql->bindValue(':cep', $dados['cep']);
    $sql->bindValue(':endereco', $dados['endereco']);
    $sql->bindValue(':cidade', $dados['cidade']);
    $sql->bindValue(':uf', $dados['uf']);
    $sql->bindValue(':bairro', $dados['bairro']);
    $sql->bindValue(':ativo', $dados['ativo']);
    $sql->bindValue(':created', date("Y-m-d H:i:s"));
    $sql->bindValue(':updated', date("Y-m-d H:i:s"));
    $sql->execute();
    if($sql->rowCount() > 0) {
      $id = $conn->lastInsertId();
      return $id;
    }
    return 0;
  }

  public function edit($id, $dados) {
    $database = new Database();
    $conn = $database->connection;
    $sql = "UPDATE endereco SET
    cep=:cep, endereco=:endereco, cidade=:cidade,
    uf=:uf,bairro=:bairro, ativo=:ativo, updated=:updated 
    WHERE idendereco=:idendereco";
    $sql = $conn->prepare($sql);
    $sql->bindValue(':cep', $dados['cep']);
    $sql->bindValue(':endereco', $dados['endereco']);
    $sql->bindValue(':cidade', $dados['cidade']);
    $sql->bindValue(':uf', $dados['uf']);
    $sql->bindValue(':bairro', $dados['bairro']);
    $sql->bindValue(':ativo', $dados['ativo']);
    $sql->bindValue(':updated', date("Y-m-d H:i:s"));
    $sql->bindValue(':idendereco', $id);
    $sql->execute();
    return ($sql->rowCount() > 0);
  }


  public function delete($id) {
    $database = new Database();
    $conn = $database->connection;
    $sql = "DELETE FROM endereco WHERE idendereco = $id";
    $sql = $conn->query($sql);
    return ($sql->rowCount() > 0);
  }
}