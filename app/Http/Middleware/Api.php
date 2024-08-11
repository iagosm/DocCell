<?php 

namespace App\Http\Middleware;

class Api {

  public function handle($request, $next) { // responsavel por executar o middleware
    
    $request->getRouter()->setContentType('application/json');
    // Executa o proximo nivel do middleware
    return $next($request);
  }
}