<?php 

namespace App\Http\Middleware;

class Maintenance {

  public function handle($request, $next) { // responsavel por executar o middleware
    // Estado de manuntenção da pagina
    if(getenv('MAINTENANCE') == 'true') {
      throw new \Exception("Página em manutenção. Tente novamente mais tarde!", 200);
    }
    // Executa o proximo nivel do middleware
    return $next($request);
  }
}