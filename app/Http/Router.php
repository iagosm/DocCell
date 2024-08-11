<?php

namespace App\Http;

use \Closure;
use \Exception;
use ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

class Router {
  private $url = ''; // url completa do projeto ( raiz )
  private $prefix = ''; // prefixo de todas as rotas
  private $routes = []; // indice de rotas
  private $request;  // instancia de request
  private $contentType = 'text/html';  // instancia de request

  public function __construct($url) { // responsavel por iniciar a class
    $this->request = new Request($this);
    $this->url = $url;
    $this->setPrefix();
  }

  public function setContentType($contentType) {
    $this->contentType = $contentType;
  }

  private function setPrefix() { // responsavel por definir o prefix das rotas
    // Informações da url atual
    $parseUrl = parse_url($this->url);
    // Define o prefixo
    $this->prefix = $parseUrl['path'] ?? '';
  }

  private function addRoute($method, $route, $params = []) { // Add uma rota na class
    // Validação dos Parametros
    foreach($params as $key => $value) { // trocando a posição numerica para controller
      if($value instanceof Closure) {
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }

    // Middlewares das rotas
    $params['middlewares'] = $params['middlewares'] ?? [];
    // Variaveis da rota
    $params['variables'] = [];
    // Padrão de validação das variaveis das rotas
    $patternVariable = '/{(.*?)}/';
    if(preg_match_all($patternVariable, $route, $matches)) {
      $route = preg_replace($patternVariable, '(.*?)', $route);
      $params['variables'] = $matches[1];
    }

    // Padrão de validação da URL
    $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
    
    // Add Route dentro da class
    $this->routes[$patternRoute][$method] = $params;
  }
  
  public function get($route, $params = []) { // definir a rota de get
    return $this->addRoute('GET', $route, $params);
  }

  public function post($route, $params = []) { // definir a rota de post
    return $this->addRoute('POST', $route, $params);
  }

  public function put($route, $params = []) { // definir a rota de put
    return $this->addRoute('PUT', $route, $params);
  }

  public function delete($route, $params = []) { // definir a rota de delete
    return $this->addRoute('DELETE', $route, $params);
  }

  private function getUri() { // retornar a uri desconsiderando o prefix
    // URI DA REQUEST
    $uri = $this->request->getUri();

    // Fatia a URI com prefix
    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
    // retorna a URL sem prefix
    // return rtrim(end($xUri), '/');
    return end($xUri);
  }

  private function getRoute() { // Retornar os dados da rota atual
    // URI
    $uri = $this->getUri();
    // Method da requisição
    $httpMethod = $this->request->getHttpMethod();
    // Valida as rotas
    foreach($this->routes as $patternRoute=>$methods) {
      // verifica se a rota bate com o padrão
      if(preg_match($patternRoute, $uri, $matches)) {
        // verifica o método
        if(isset($methods[$httpMethod])) {
          
          // remove a primeira posição.
          unset($matches[0]);
          // Chaves das variaveis
          
          // Variaveis processadas
          $keys = $methods[$httpMethod]['variables'];
          $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
          $methods[$httpMethod]['variables']['request'] = $this->request;
          // return dos parametros da rota
          return $methods[$httpMethod];
        }
        throw new Exception("Método não permitido", 405);
      }
    }
    // URL não encontrada
    throw new Exception("URL não encontrada", 404);
  }

  public function run() { // Metodo responsavel por executar a rota atual
    try {

      // Obtem a rota atual
      $route = $this->getRoute(); 
      
     // verifica o controlador
     if(!isset($route['controller'])) {
      throw new Exception("URL não pode ser processada", 500);
     } 
     // Argumentos da função
     $args = [];
     //Reflection
     $reflection = new ReflectionFunction($route["controller"]);
     foreach($reflection->getParameters() as $parameter) {
      $name = $parameter->getName();
      $args[$name] = $route['variables'][$name] ?? '';
     } 
     // retorna execução da fila de middlewares
     return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);
    }catch(Exception $e) {
      return new Response($e->getCode(), $this->getErrorMessage($e->getMessage()), $this->contentType);
    }
  }
  
  private function getErrorMessage($message) {
    switch ($this->contentType) {
      case 'application/json':
        return [
          'error' => $message
        ];
        break;
      default:
        return $message;
        break;
    }
  }

  public function getCurrentUrl() {
    return $this->url.$this->getUri();
  }

  public function redirect($route) { // redirecionar a url
    $url = $this->url.$route;
    header('location: '. $url);exit;
  } 
}