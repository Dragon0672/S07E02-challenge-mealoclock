<?php

namespace Core;

class Application {

  public function __construct() {

    // On crée le routeur
    $this->router = new \Altorouter();

    // $_SERVER['BASE_URI'] est fourni grâce au fichier .htaccess, si absent => "/"
    $this->router->basePath = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '/';
    // Je définis l'URL de base (pour retirer /oclock/S06/toto/tata/okanbanqui est spécifique à chaque machine)
    $this->router->setBasePath($this->router->basePath);

    // On lance le mapping
    $this->mapping();
  }

  public function mapping() {
    // ----- ROUTES -----
    $this->router->map('GET', '/', 'Main#index', 'home');
  }

  public function run() {

      // Je récupère les données de Altorouter
      $match = $this->router->match();

      // ----- DISPATCHER -----

      // Si une route correspond à l'URL
      if ($match !== false) {
        // Je regarde quel controller et quelle
        // méthode je dois exécuter
        $controllerParts = explode('#', $match['target']);

        // J'exécute la bonne méthode
        $controllerName = $controllerParts[0];
        $methodName = $controllerParts[1];

        // J'instancie le controller
        $controller = new $controllerName();
        // J'appelle la méthode du controller
        $controller->$methodName($match['params']);
    }
    else {
        // TODO faire une belle page 404
        echo '404';
    }
  }
}
