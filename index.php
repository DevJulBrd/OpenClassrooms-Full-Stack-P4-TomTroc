<?php

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/autoload.php';

$action = Utils::request('action', 'home');

try {
    switch ($action) {
        case 'home':
            $controller = new HomeController();
            $controller->showHome();
            break;
        
        case 'register':
            $auth = new AuthController();
            $auth->showRegister();
            break;

        case 'login':
            (new AuthController())->login();
            break;

        case 'logout':
            (new AuthController())->logout();
            break;


        default:
            throw new RuntimeException("Action inconnue: " . htmlspecialchars($action));
    }
} catch (Exception $e) {
    $view = new View('Erreur');
    $view->render('error', ['message' => $e->getMessage()]);
}