<h1 class="register-title profile-title">Mon compte</h1>

<div class="profile-header">
  <div class="profile-block profile-align">
    <div class="profile-container">
      <div class="profile-img-container">
        <?php
          // URL de l'avatar : si null ou vide → image par défaut
          $avatarUrl = $user->getImageUrl() ?: '../images/profile-default.jpg';
        ?>
        <img src="<?= htmlspecialchars($avatarUrl) ?>"
             alt="Photo de profil" class="profile-img">
          <form action="index.php?action=updateAvatar"
                method="post"
                enctype="multipart/form-data"
                class="profile-avatar-form">

              <label class="profile-update">
                modifier
                <input type="file"
                      name="avatar"
                      accept="image/*"
                      class="profile-avatar-input"
                      onchange="this.form.submit()">
              </label>
          </form>
      </div>

      <div class="profile-img-container">
        <p class="profile-pseudo"><?= htmlspecialchars($user->getUsername()) ?></p>
        <p class="profile-timer">Membre depuis <?= htmlspecialchars($memberFor) ?></p>
        <p class="profile-counter-title">BIBLIOTHEQUE</p>
        <p class="profile-counter">
          <i class="fa-solid fa-book"></i> <?= (int)$bookCount ?> livres
        </p>
      </div>
    </div>
  </div>

  <section class="profile-block">
    <h2 class="profile-second-title">Vos informations personnelles</h2>
    <div>
      <label class="register-label">
        Adresse email<br>
        <input class="register-input profile-input"
               type="email"
               value="<?= htmlspecialchars($user->getEmail()) ?>"
               readonly>
      </label>

      <label class="register-label">
        Mot de passe<br>
        <?php $fakeMasked = str_repeat('•', 10); ?>
        <input class="register-input profile-input"
              type="text"
              value="<?= $fakeMasked ?>"
              readonly>
      </label>

      <label class="register-label">
        Pseudo<br>
        <input class="register-input profile-input"
               type="text"
               value="<?= htmlspecialchars($user->getUsername()) ?>"
               readonly>
      </label>
    </div>
    <button class="register-button profile-button">Enregistrer</button>
  </section>
</div>

<div class="profile-block-books">
  <?php if (empty($books)): ?>
    <p>Tu n’as pas encore ajouté de livres.</p>
  <?php else: ?>
    <div class="profile-books-titles-container">
      <div class="profile-books-titles">Photo</div>
      <div class="profile-books-titles">Titre</div>
      <div class="profile-books-titles">Auteur</div>
      <div class="profile-books-titles">Description</div>
      <div class="profile-books-titles">Disponibilite</div>
      <div class="profile-books-titles">Action</div>
    </div>
    <div class="profile-books-colors">
        <?php foreach ($books as $b): ?>
            <div class="profile-book-container">
                <div class="profile-book-title-container">
                    <div class="profile-book-img-container">
                        <img src="<?= htmlspecialchars($b->getImage_path() ?? '') ?>"
                             alt="couverture du livre <?= htmlspecialchars($b->getTitle()) ?>"
                             class="profile-book-img">
                    </div>
                    <div class="profile-book-info-container">
                        <p class="profile-book-title"><?= htmlspecialchars($b->getTitle()) ?></p>
                        <p class="profile-book-title"><?= htmlspecialchars($b->getAuthor() ?? '') ?></p>

                        <?php if ($b->getStatus() === 'available'): ?>
                            <div class="profile-book-status profile-available mobil">disponible</div>
                        <?php elseif ($b->getStatus() === 'reserved'): ?>
                            <div class="profile-book-status profile-reserved mobil">réservé</div>
                        <?php else: ?>
                            <div class="profile-book-status profile-unavailable mobil">non dispo.</div>
                        <?php endif; ?> 
                    </div>
                </div>
            
                <p class="profile-book-description">
                    <?= nl2br(htmlspecialchars($b->getDescription() ?? '')) ?>
                </p>

                <?php if ($b->getStatus() === 'available'): ?>
                  <div class="profile-book-status profile-available desktop">disponible</div>
                <?php elseif ($b->getStatus() === 'reserved'): ?>
                  <div class="profile-book-status profile-reserved desktop">réservé</div>
                <?php else: ?>
                  <div class="profile-book-status profile-unavailable desktop">non dispo.</div>
                <?php endif; ?> 

                <div class="profile-book-action-container">
                  <a href="index.php?action=editBook&id=<?= (int)$b->getId() ?>" class="profile-book-action">
                    Éditer
                  </a>
                    <form method="post"
                          action="index.php?action=deleteBook"
                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                        <input type="hidden" name="book_id" value="<?= (int)$b->getId() ?>">
                        <button type="submit" class="profile-book-action profile-book-delete">
                          Supprimer
                        </button>
                    </form>
                </div>
            </div>           
        <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>



