<?php 
// Démarrage de la session 
session_start();

// Toute les données utiles  
define('TEMPLATE_VIEW_PATH', './views/templates/'); // Le chemin vers les templates de vues
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php'); // Le chemin vers le template principal

// Données de connexion à la base de données
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'P4-Tom-Troc');
define('DB_USER', 'root');
define('DB_PASS', '');