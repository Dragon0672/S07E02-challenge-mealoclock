<?php

namespace Source;

class Application {

  public function __construct() {

    // On crée le routeur
    $this->router = new \AltoRouter();

    // $_SERVER['BASE_URI'] est fourni grâce au fichier .htaccess, si absent => "/"
    $basePath = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';
    // Je définis l'URL de base (pour retirer /oclock/S06/toto/tata/okanbanqui est spécifique à chaque machine)
    $this->router->setBasePath($basePath);

    // On lance le mapping
    $this->mapping();
  }

    public function mapping() {

        // On mappe toutes nos URL
        // La page d'accueil
        $this->router->map('GET', '/', ['Main', 'home'], 'home');


        // ---------------------------
        // Communities
        // ---------------------------
        // La page d'une communauté
        $this->router->map('GET', '/communities/[a:slug]', '', 'communities');

        // ---------------------------
        // Events
        // ---------------------------
        // Liste des évènements
        $this->router->map('GET', '/events', '', 'events');
        // Page d'un évènement
        $this->router->map('GET', '/events/[i:id]', '', 'event');
        $this->router->map('GET', '/events/[i:id]/signupdate', '', 'events_signupdate');
        $this->router->map('GET', '/events/create', '', 'events_create');
        // /admin/event/123/update
        // /profile/event/123/update
        $this->router->map('GET', '/[admin|profile:domain]/events/[i:id]/update', '', 'events_update');

        // ---------------------------
        // Pages statiques
        // ---------------------------
        $this->router->map('GET', '/cgu', '', 'cgu');

        // ---------------------------
        // Admin
        // ---------------------------
        $this->router->map('GET', '/admin/communities', '', 'admin_communities');
        $this->router->map('GET', '/admin/communities/create', '', 'admin_communities_create');
        $this->router->map('GET', '/admin/communities/[i:id]/update', '', 'admin_communities_update');
        $this->router->map('GET', '/admin/communities/[i:id]/delete', '', 'admin_communities_delete');
        $this->router->map('GET', '/admin/events', '', 'admin_events');
        $this->router->map('GET', '/admin/events/[i:id]/delete', '', 'admin_events_delete');
        $this->router->map('GET', '/admin/events/[i:id]/update', '', 'admin_events_update');
        $this->router->map('GET', '/admin/members', '', 'admin_members');
        $this->router->map('GET', '/admin/members/update/status', '', 'admin_member_status');
        $this->router->map('GET', '/admin/members/[i:id]/delete', '', 'admin_member_delete');
        $this->router->map('GET', '/admin/members/update/role', '', 'admin_member_role');

        // ---------------------------
        // Connexion
        // ---------------------------
        // Page de création de compte
        $this->router->map('GET', '/signup', '', 'signup');
        // Page de connexion
        $this->router->map('GET', '/login', '', 'login');
        // Page de déconnexion
        $this->router->map('GET', '/logout', '', 'logout');
        $this->router->map('GET', '/forgot_password', '', 'forgot_password');
        $this->router->map('GET', '/update_password', '', 'update_password');

        // ---------------------------
        // Profil
        // ---------------------------
        // Page de profil
        $this->router->map('GET', '/profile', '', 'profile');
        $this->router->map('GET', '/profile/update', '', 'profil_update');
    }

  public function run() {

      // Je récupère les données de Altorouter
      $match = $this->router->match();

      if(!$match) {
          // $controller = new \Source\Controllers\Main();
          // $controller->error404();
          $controllerName = "\Source\Controllers\Main";
          $methodName = 'error404';
      }
      else {
        // ----- DISPATCHER -----

          $controllerName = "\Source\Controllers\\".$match['target'][0];
          $methodName = $match['target'][1];

      }


        // J'instancie le controller
        $controller = new $controllerName();
        $controller->$methodName();
  }
}
