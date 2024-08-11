<?php

namespace App\Http;

class Response {
  private $httpCode = 200; // Código do status
  private $headers = []; // Cabeçalho do response
  private $contentType = 'text/html'; // Tipo de Conteudo retornado
  private $content; // Conteudo do response

  // Responsavel por inicar a classe e definir valores
  public function __construct($httpCode, $content, $contentType = 'text/html') {

    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->setContentType($contentType);
  }

  public function setContentType($contentType) { // responsavel por alterar o contentType
    $this->contentType = $contentType;
    $this->addHeader('Content-Type', $contentType);
  }

  public function addHeader($key, $value) { // Responsavel por add metodo no cabeçalho
    $this->headers[$key] = $value;
  }

  private function sendHeaders() { // Definir Status
    http_response_code($this->httpCode);
    //Enviar os headers
    foreach($this->headers as $key=>$value) {
      header($key.': '.$value);
    }
  }

  public function sendResponse() { // Metodo responsavel para enviar resposta ao usuario
    $this->sendHeaders();
     switch($this->contentType) {
      case 'text/html':
        echo $this->content;
         exit;
      case 'application/json':
        echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }  
  }
}