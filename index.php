<?php

require __DIR__.'/includes/app.php';

use \App\Http\Router;

// Inicia o router
$obRouter = new Router(URL);

// Incluir paginas de rotas
include __DIR__.'/routes/pages.php';
include __DIR__.'/routes/admin.php';
include __DIR__.'/routes/api.php';

// Imprime o response da rota
$obRouter->run()->sendResponse();