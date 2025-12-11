<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AccountController;
use App\Controllers\BooksController;
use App\Controllers\MessageController;
use App\Services\Utils;
use App\Views\View;

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
            $auth = new AuthController();
            $auth->login();
            break;

        case 'logout':
            $auth = new AuthController();
            $auth->logout(); 
            break;

        case 'profile':
            $account = new AccountController();
            $account->showProfile();
            break;

        case 'updateAvatar':
            $account = new AccountController();
            $account-> updateAvatar();
            break;

        case 'deleteBook':
            $account = new AccountController();
            $account->deleteBook();
            break;

        case 'books':
            $books = new BooksController();
            $books->showBooks();
            break;

        case 'book':
            $book = new BooksController();
            $book->showBook();
            break;

        case 'editBook':
            $book = new BooksController ();
            $book->editBook();
            break;

        case 'updateBook':
            $book = new BooksController();
            $book->updateBook();
            break;

        case 'inbox':
            $messageController = new MessageController();
            $messageController->inbox();
            break;

        case 'inboxDesktop':
            $messageController = new MessageController();
            $messageController->inboxDesktop();
            break;
        
        case 'conversation':
            $messageController = new MessageController();
            $messageController->showConversation();
            break;

        case 'startConversation':
            $messageController = new MessageController();
            $messageController->newConversation();
            break;

        case 'startConversationDesktop':
            $messageController = new MessageController();
            $messageController->newConversationDesktop();
            break;
    
        case 'sendMessage':
            $messageController = new MessageController();
            $messageController->sendMessage();
            break;

        case 'publicProfile':
            $account = new AccountController();
            $account->showPublicProfile();
            break;


        default:
            throw new RuntimeException("Action inconnue: " . htmlspecialchars($action));
    }
} catch (Exception $e) {
    $view = new View('Troc Tom - Erreur');
    $view->render('error', ['message' => $e->getMessage()]);
}