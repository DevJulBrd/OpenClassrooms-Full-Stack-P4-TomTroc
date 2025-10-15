<section class="register-container">
    <div class="register-form-container">
        <h1 class="register-title">Connexion</h1>

        <?php if (!empty($errors)): ?>
        <div class="register-errors">
            <p class="register-title-errors">Le formulaire contient des erreurs :</p>
            <ul ul class="register-list-errors">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form class="register-form" method="post" action="index.php?action=login" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

        <div class="register-input-container">
            <label class="register-label" for="email">Email</label><br>
            <input class="register-input" id="email" name="email" type="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        </div>

        <div class="register-input-container">
            <label class="register-label" for="password">Mot de passe</label><br>
            <input class="register-input" id="password" name="password" type="password" required>
        </div>

        <button class="register-button" type="submit">Se connecter</button>
        </form>

        <p class="register-text">Pas de compte ? <a class="register-link" href="index.php?action=register">Inscrivez-vous</a></p>
    </div>
      <img class="register-img" src="./images/register.jpg" alt="Bibliothèque remplie de livres">
</section>