<?php

namespace App\Controllers;

use App\Models\Repositories\BookRepository;
use App\Models\Entities\Book;
use App\Views\View;
use App\Services\Utils;

class BooksController
{
    public function showBooks(): void
    {
        $bookRepository = new BookRepository();
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';

        if ($q !== '') {
            $books = $bookRepository->searchByTitle($q);
        } else {
            $books = $bookRepository->bookList();
        }

        $view = new View('Tom Troc - Livres');
        $view->render('books', [
            'books'  => $books,
            'search' => $q,
        ]);
    }

    public function showBook(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id <= 0) {
            throw new \RuntimeException('ID de livre manquant ou invalide.');
        }

        $bookRepo = new BookRepository();
        $book     = $bookRepo->bookByID($id);

        if (!$book) {
            throw new \RuntimeException('Livre introuvable.');
        }

        $view = new View('Tom Troc - Livre');
        $view->render('book', [
            'book' => $book,
        ]);
    }

    /**
     * Affiche le formulaire de modification
     */
    public function editBook(): void 
    {
        $userId = Utils::requireAuth();

        $bookId = (int)($_GET['id'] ?? 0);
        if ($bookId <= 0) {
            throw new \RuntimeException('Livre introuvable');
        }

        $bookRepo = new BookRepository();
        $book     = $bookRepo->bookByID($bookId);

        if (!$book) {
            throw new \RuntimeException('Livre introuvable');
        }

        if ((int)$book->getUser_id() !== $userId) {
            throw new \RuntimeException('Accès refusé');
        }

        $view = new View('Tom Troc - Modifier son livre');
        $view->render('book_edit', [
            'book'   => $book,   // objet Book
            'errors' => [],
        ]);
    }

/**
 * Traite les modifications
 */
    public function updateBook() : void 
    {
        $userId = Utils::requireAuth();

        if (!Utils::isPost()) {
            Utils::redirect('index.php?action=profile');
        }

        $bookId = (int)($_POST['id'] ?? 0);
        $title  = trim((string)($_POST['title'] ?? ''));
        $author = trim((string)($_POST['author'] ?? ''));
        $desc   = trim((string)($_POST['description'] ?? ''));
        $status = ($_POST['status'] ?? 'available');

        if (!in_array($status, ['available', 'reserved', 'unavailable'], true)) {
            $status = 'available';
        }

        $errors = [];
        if ($title === '')  $errors[] = 'Le titre est requis.';
        if ($author === '') $errors[] = "L'auteur est requis.";
        if ($desc === '')   $errors[] = "La description est requise.";

        $bookRepo = new BookRepository();
        $book     = $bookRepo->bookByID($bookId);

        if (!$book || (int)$book->getUser_id() !== $userId) {
            throw new \RuntimeException('Accès refusé.');
        }

        $imagePath     = $book->getImage_path();
        $oldImagePath  = $imagePath;

        if (!empty($_FILES['image_file']['name'])) {
            $file = $_FILES['image_file'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'Échec de l’upload de la photo.';
            } else {
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mime  = $finfo->file($file['tmp_name']);
                $allowed = [
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/webp' => 'webp'
                ];
                if (!isset($allowed[$mime])) {
                    $errors[] = 'Format image invalide (jpg, png ou webp).';
                }

                if ($file['size'] > 3 * 1024 * 1024) {
                    $errors[] = 'Image trop lourde (max 3 Mo).';
                }

                if (!$errors) {
                    if (!is_dir(UPLOADS_BOOKS_DIR)) {
                        mkdir(UPLOADS_BOOKS_DIR, 0775, true);
                    }
                    $ext  = $allowed[$mime];
                    $name = bin2hex(random_bytes(8)) . "." . $ext;

                    $dest = UPLOADS_BOOKS_DIR . $name;
                    if (!move_uploaded_file($file['tmp_name'], $dest)) {
                        $errors[] = 'Impossible de sauvegarder le fichier.';
                    } else {
                        // Nouveau chemin public
                        $imagePath = UPLOADS_BOOKS_URL . $name;

                        // suppression de l’ancienne image si besoin
                        if ($oldImagePath 
                            && $oldImagePath !== $imagePath 
                            && strpos($oldImagePath, UPLOADS_BOOKS_URL) === 0
                        ) {
                            // on récupère juste le nom de fichier
                            $oldFileName = substr($oldImagePath, strlen(UPLOADS_BOOKS_URL));
                            $oldFilePath = UPLOADS_BOOKS_DIR . $oldFileName;

                            if (is_file($oldFilePath)) {
                                @unlink($oldFilePath);
                            }
                        }
                    }
                }
            }
        }

        // Si erreurs, réaffiche le formulaire avec un Book "temporaire"
        if ($errors) {
            $formBook = (new Book())
                ->setId($bookId)
                ->setUser_id($userId)
                ->setTitle($title !== '' ? $title : $book->getTitle())
                ->setAuthor($author !== '' ? $author : $book->getAuthor())
                ->setDescription($desc !== '' ? $desc : $book->getDescription())
                ->setStatus($status)
                ->setImage_path($imagePath);

            $view = new View('Modifier le livre');
            $view->render('book_edit', [
                'book'   => $formBook,  
                'errors' => $errors,
            ]);
            return;
        }

        // Mise à jour en BDD
        $fields = [
            'title'       => $title,
            'author'      => $author,
            'description' => $desc,
            'status'      => $status,
            'image_path'  => $imagePath,
        ];

        $ok = $bookRepo->updateByOwner($bookId, $userId, $fields);

        if (!$ok) {
            throw new \RuntimeException('La mise à jour a échoué.');
        }

        Utils::redirect('index.php?action=book&id=' . $bookId);
    }

}
