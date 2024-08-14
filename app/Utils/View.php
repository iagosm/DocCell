<?php 

namespace App\Utils;

class View { // metodos responsaveis para renderizar view

  private static $vars = []; // variaveis padrões da view

  public static function init($vars = []) { // responsavel por definir os dados iniciais da classe
    self::$vars = $vars;
  }

  private static function getContentView($view) { // responsavel por retornar o conteudo de uma view
    $file = __DIR__.'/../../resources/view/'.$view.'.html';
    return file_exists($file) ? file_get_contents($file) : '';
  }
  
  public static function findScript($vars) {
   
    $scripts = '';
    foreach($vars as $script) {
      $file = __DIR__.'/../../resources/javascript/'.$script.'.js';
      if (file_exists($file)) {
        $scripts .= '<script src="../resources/javascript/' . $script . '.js"></script>' . "\n";
      }
    }
    return $scripts;
  }

  public static function render($view, $vars = []) { // metodo responsavel por retornar conteudo renderizado de uma view
    $contentView = self::getContentView($view);
    // merge de varaiveis da view
    $vars = array_merge(self::$vars, $vars);

    $keys = array_keys($vars);
    $keys = array_map(function($item){
      return '{{'.$item.'}}';
    }, $keys);
    return str_replace($keys, array_values($vars), $contentView);
  }
}
