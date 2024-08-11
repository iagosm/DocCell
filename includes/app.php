<?php 

require __DIR__.'/../vendor/autoload.php';


use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

// Carregar variaveis de ambiente
Environment::load(__DIR__.'/../');

// Define as configurações de banco de dados
Database::config(
  getenv('DB_HOST'),
  getenv('DB_NAME'),
  getenv('DB_USER'),
  getenv('DB_PASS'),
  getenv('DB_PORT')
);

// Define a constante de url do projeto
define('URL', getenv('URL'));

// define valor padrão das variaveis
View::init([
  'URL' => URL
]);

// Define mapeamento de middlewares
MiddlewareQueue::setMap([
'maintenance' => \App\Http\Middleware\Maintenance::class,
'required-admin-logout' => \App\Http\Middleware\RequireAdminLogout::class,
'required-admin-login' => \App\Http\Middleware\RequireAdminLogin::class,
'api' => \App\Http\Middleware\Api::class,
]);

// Define mapeamento de middlewares em todas as rotas
MiddlewareQueue::setDefault([
'maintenance'
]);
