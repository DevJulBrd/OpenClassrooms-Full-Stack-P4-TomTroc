<?php

namespace App\Controllers;

use App\Views\View;
use App\Services\Utils;
use App\Models\Repositories\UserRepository;
use Exception;

class AuthController
{
    public function showRegister(): void
    {
        $errors = [];
        $old = ['email'=>'', 'username'=>''];

        if (Utils::isPost()) {
            // Inputs
            $email     = trim((string)($_POST['email'] ?? ''));
            $username  = trim((string)($_POST['username'] ?? ''));
            $password  = (string)($_POST['password'] ?? '');

            $old = compact('email','username');

            // Validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide.";
            }
            if ($username === '' || mb_strlen($username) < 3 || mb_strlen($username) > 60) {
                $errors[] = "Le pseudo doit faire entre 3 et 60 caractères.";
            }
            if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {
                $errors[] = "Le pseudo ne doit contenir que lettres, chiffres, . _ -";
            }
            if (mb_strlen($password) < 8) {
                $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
            }

            // Unicité
            $userRepository = new UserRepository();
            $userEmail = $userRepository->findByEmail($email);
            $userUsername = $userRepository->findByUsername($username);
            if (!$errors && $userEmail) {
                $errors[] = "Cet email est déjà utilisé.";
            }
            if (!$errors && $userUsername) {
                $errors[] = "Ce pseudo est déjà pris.";
            }

            // Création + auto-login
            if (!$errors) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $userId = $userRepository->create($email, $username, $hash);

                $_SESSION['user_id'] = $userId;

                // régénérer un token CSRF (bonne pratique)
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                Utils::redirect('index.php?action=profile');
            }
        }

        $view = new View('TomTroc - Inscription');
        $view->render('register', [
            'errors' => $errors,
            'old'    => $old,
            'csrf'   => Utils::csrfToken(),
        ]);
    }

    public function welcome(): void
    {
        $userId = $_SESSION['user_id'];

        if (empty($userId)) {
            Utils::redirect('index.php?action=register');
        }
        
        $userRepository = new UserRepository();
        $userRepository->findById($userId);

        $view = new View('TomTroc');
        $view->render('home', '');
    }

    public function login(): void
    {
        $errors = [];
        $old = ['email' => ''];

        if (Utils::isPost()) {
            // Inputs
            $email    = trim((string)($_POST['email'] ?? ''));
            $password = (string)($_POST['password'] ?? '');
            $old['email'] = $email;

            // Validation basique
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide.";
            }
            if ($password === '') {
                $errors[] = "Mot de passe requis.";
            }

            // Vérification en BDD
            if (!$errors) {
                $userRepository = new UserRepository();
                $user = $userRepository->findByEmail($email);

                if (!$user) {
                    $errors[] = "Identifiants incorrects.";
                } else {
                    if (!password_verify($password, $user->getPasswordHash())) {
                        $errors[] = "Identifiants incorrects.";
                    } else {
                        // Connexion: on stocke l'id en session
                        $_SESSION['user_id'] = $user->getId();

                        // (Optionnel) régénérer le token CSRF
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                        Utils::redirect('index.php?action=profile');
                    }
                }
            }
        }

        // Affichage du formulaire
        $view = new View('TomTroc - Connexion');
        $view->render('login', [
            'errors' => $errors,
            'old'    => $old,
        ]);
    }

    public function logout(): void
    {
        // Déconnexion propre
        session_unset();    // vide la session
        session_destroy();  // détruit la session
        // (Optionnel) redémarrer une session vide si tu utilises CSRF globalement:
        session_start();

        Utils::redirect('index.php?action=home');
    }
}


