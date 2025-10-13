<?php 
// Autoload des classes, si la classe existe dans un des dossiers, on l'inclut avec require_once.
spl_autoload_register(function($className) {
    // On va voir dans le dossier Service si la classe existe.
    if (file_exists('services/' . $className . '.php')) {
        require_once 'services/' . $className . '.php';
    }

    // On va voir dans le dossier Model si la classe existe.
    if (file_exists('models/' . $className . '.php')) {
        require_once 'models/' . $className . '.php';
    }

    // On va voir dans le dossier Controller si la classe existe.
    if (file_exists('controllers/' . $className . '.php')) {
        require_once 'controllers/' . $className . '.php';
    }

    // On va voir dans le dossier View si la classe existe.
    if (file_exists('views/' . $className . '.php')) {
        require_once 'views/' . $className . '.php';
    }
    
});