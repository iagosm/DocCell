<?php

namespace App\Http\Middleware;

use \App\Session\Admin\Login as SessionAdminLogin;


class RequireAdminLogout {

  public function handle($request, \Closure $next) {
    // verifica se está logado
    if(SessionAdminLogin::isLogged()) {
      $request->getRouter()->redirect('/admin');
    }
    return $next($request);
  }
}