<?php

namespace App\Controllers;

use App\Models\Repositories\BookRepository;;
use App\Views\View;

class HomeController
{
    public function showHome(): void
    {
        $books = [];
        $bookRepository = new BookRepository();
        $books = $bookRepository->bookListHome(0, 4);
        $view = new View('Tom Troc - Accueil');
        $view->render('home', [
            'books' => $books,
        ]);
    }
}
