<section class="register-container">
  <div class="register-form-container">
    <h1 class="register-title">Inscription</h1>

    <?php if (!empty($errors)): ?>
      <div class="register-errors">
        <p class="register-title-errors">Le formulaire contient des erreurs :</p>
        <ul class="register-list-errors">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form class="register-form" method="post" action="index.php?action=register" novalidate>

      <div class="register-input-container">
        <label class="register-label" for="username" >Pseudo</label><br>
        <input class="register-input" id="username" name="username" type="text" required maxlength="60"
              value="<?= htmlspecialchars($old['username'] ?? '') ?>">
      </div>

      <div class="register-input-container">
        <label class="register-label" for="email">Adresse email</label><br>
        <input class="register-input" id="email" name="email" type="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
      </div>

      <div class="register-input-container">
        <label class="register-label" for="password">Mot de passe</label><br>
        <input class="register-input" id="password" name="password" type="password" required minlength="8">
      </div>

      <button class="register-button" type="submit">S’inscrire</button>
    </form>
  
  
    <p class="register-text">Déjà inscrit ? <a class="register-link" href="index.php?action=login">Connectez-vous</a></p>
  </div>
  <img class="register-img" src="./images/register.jpg" alt="Bibliothèque remplie de livres">

</section>

