<?php
 
 namespace App\Http\Middleware;

 class Queue {

  private static $map = []; // Mapeamento de middleware
  private static $default = []; // Mapeamento de middleware em all routes
  private $middlewares = []; // fila de middleware a serem executados
  private $controller; // Função de execução do controlador Closure
  private $controllerArgs = []; // Argumentos da função do controlador

  public function __construct($middlewares, $controller, $controllerArgs) { // responsavel por contruir a classe de fila de middlewares
    $this->middlewares = array_merge(self::$default, $middlewares);
    $this->controller = $controller; 
    $this->controllerArgs = $controllerArgs;
  }

  public static function setMap($map) { // responsavel por definir os metodos de mapeamento
    self::$map = $map;
  }

  public static function setDefault($default) { // responsavel por definir os metodos de mapeamento
    self::$default = $default;
  }

  public function next($request) { // responsavel em executar o proximo nivel da fila de middlewares
    // Verifica se a fila está vazia
    
    if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);
    
    // Middleware atual
    $middleware = array_shift($this->middlewares);
    
    
    if(!isset(self::$map[$middleware])) {
      throw new \Exception("Problemas ao processar o middleware da requisição", 500);
    }

    // Next
    $queue = $this;
    $next = function($request) use($queue) {
      return $queue->next($request);
    };
    // Executa o middleware
    return (new self::$map[$middleware])->handle($request, $next);
  }
}