<?php

namespace App\Controllers;

use App\Models\Repositories\UserRepository;
use App\Models\Repositories\BookRepository;
use App\Views\View;
use App\Services\Utils;
use DateTime;
use Exception;

class AccountController
{
    public function showProfile(): void
    {
        // Id utilisateur connecté (Utils::requireAuth doit renvoyer l'id)
        $me = Utils::requireAuth();

        $userRepository  = new UserRepository();
        $bookRepository  = new BookRepository();

        // 🔹 $user est un OBJET User
        $user = $userRepository->findById($me);
        if (!$user) {
            throw new Exception('Utilisateur introuvable.');
        }

        // 🔹 $books reste un tableau de livres (arrays) comme dans ton BookRepository
        $books     = $bookRepository->listByUser($me);
        $bookCount = $bookRepository->countByUser($me);

        // 🔹 created_at vient de l'objet User
        $createdAt = new DateTime($user->getCreatedAt());
        $memberFor = Utils::humanDiff($createdAt, new DateTime());

        $view = new View('Tom Troc - Mon profil');
        $view->render('profile', [
            'user'       => $user,      
            'books'      => $books, 
            'bookCount'  => $bookCount,
            'memberFor'  => $memberFor,
        ]);
    }

public function updateAvatar(): void
{
    $me = Utils::requireAuth();

    if (!Utils::isPost()) {
        Utils::redirect('index.php?action=profile');
    }

    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erreur lors de l’upload de l’image.");
    }

    $file = $_FILES['avatar'];

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new Exception("Fichier trop volumineux (max 2 Mo).");
    }

    $finfo    = new \finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    if (!isset($allowedTypes[$mimeType])) {
        throw new Exception("Format d'image non supporté (jpg, png, gif, webp uniquement).");
    }

    $extension = $allowedTypes[$mimeType];

    $fileName   = 'avatar_' . $me . '_' . time() . '.' . $extension;

    $uploadDir  = __DIR__ . '/../public/uploads/avatars';
    $publicPath = 'public/uploads/avatars/' . $fileName;

    $targetPath = $uploadDir . '/' . $fileName;

    $userRepository = new UserRepository();
    $user = $userRepository->findById($me);
    $oldImage = $user ? $user->getImageUrl() : null;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("Impossible d’enregistrer le fichier envoyé.");
    }

    $userRepository->updateImageUrl($me, $publicPath);

        if ($oldImage 
        && str_starts_with($oldImage, 'public/uploads/avatars/')
    ) {
        $oldPath = __DIR__ . '/../' . $oldImage;

        if (is_file($oldPath)) {
            @unlink($oldPath);
        }
    }

    Utils::redirect('index.php?action=profile');
}


    public function deleteBook(): void
    {
        $me = Utils::requireAuth();
        if (!Utils::isPost()) {
            Utils::redirect('index.php?action=profile');
        }

        $bookId = (int)($_POST['book_id'] ?? 0);
        if ($bookId <= 0) {
            throw new Exception('Livre invalide.');
        }

        $bookRepository = new BookRepository();
        $ok = $bookRepository->deleteOwned($bookId, $me);
        if (!$ok) {
            throw new Exception("Suppression impossible (livre introuvable ou ne vous appartient pas).");
        }

        Utils::redirect('index.php?action=profile');
    }

    public function showPublicProfile(): void
    {
        $publicUserId = (int)($_GET['user_id'] ?? 0);

        if ($publicUserId <= 0) {
            throw new Exception("Profil introuvable.");
        }

        $userRepository = new UserRepository();
        $bookRepository = new BookRepository();

        // 🔹 objet User
        $user = $userRepository->findById($publicUserId);
        if (!$user) {
            throw new Exception("Utilisateur introuvable.");
        }

        // 🔹 tableaux de livres
        $books = $bookRepository->listByUser($publicUserId);

        $createdAt = new DateTime($user->getCreatedAt());
        $now       = new DateTime('now');
        $memberFor = Utils::humanDiff($createdAt, $now);

        $bookCount = count($books);

        $view = new View('Tom Troc - Profil de ' . htmlspecialchars($user->getUsername()));
        $view->render('profile_public', [
            'user'       => $user, 
            'memberFor'  => $memberFor,
            'bookCount'  => $bookCount,
            'books'      => $books,
        ]);
    }
}
