<?php

namespace App\Http;

class Request {
  
  private $router; // URI da página.
  private $httpMethod; //Método da requisição.
  private $uri; // URI da página.
  private $queryParams = [];
  private $postVars = []; // Varaiveis do post da pagina.
   private $headers = []; // Cabeçalho da requisição.

   public function __construct($router) {
    $this->router = $router;
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders();
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->setUri();
  }

  private function setUri() {
    // URI completa com gets
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    // Remove gets da URI
    $xURI = explode('?', $this->uri);
    $this->uri = $xURI[0];
  }

  public function getRouter() { // responsavel por retornar intancia de router
    return $this->router;
  }

  public function getHttpMethod() { // Responsavel por retornar o HTTP da requisição
    return $this->httpMethod;
  }

  public function getUri() { // Responsavel por retornar o URI da requisição
    return $this->uri;
  }

  public function getHeaders() { // Responsavel por retornar o headers da requisição
    return $this->headers;
  }

  public function getQueryParams() { // Responsavel por retornar o headers da requisição
    return $this->queryParams;
  }
  
  public function getPostVars() { // Responsavel por retornar o headers da requisição
    return $this->postVars;
  }
}