<?php
class AuthController
{
    public function showRegister(): void
    {
        $errors = [];
        $old = ['email'=>'', 'username'=>''];

        if (Utils::isPost()) {
            // CSRF
            $token = $_POST['csrf_token'] ?? '';
            if (!Utils::checkCsrf($token)) {
                $errors[] = "Session expirée. Merci de réessayer.";
            }

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
            $userModel = new User();
            if (!$errors && $userModel->findByEmail($email)) {
                $errors[] = "Cet email est déjà utilisé.";
            }
            if (!$errors && $userModel->findByUsername($username)) {
                $errors[] = "Ce pseudo est déjà pris.";
            }

            // Création + auto-login
            if (!$errors) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $userId = $userModel->create($email, $username, $hash);

                $_SESSION['user_id'] = $userId;

                // régénérer un token CSRF (bonne pratique)
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                Utils::redirect('index.php?action=welcome');
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
        if (empty($_SESSION['user_id'])) {
            Utils::redirect('index.php?action=register');
        }
        $user = (new User())->findById((int)$_SESSION['user_id']);
        $view = new View('Bienvenue');
        $view->render('welcome', ['user' => $user]);
    }
}
