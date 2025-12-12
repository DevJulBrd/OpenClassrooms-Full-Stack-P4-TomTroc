<div class="public-profile-container">
  <div class="profile-header public-profile-header">
    <div class="profile-block profile-align public-profile-block">
      <div class="profile-container public-profile-profile-container">
        <div class="profile-img-container">
          <?php
            /** @var \App\Models\Entities\User $user */
            $avatarUrl = $user->getImageUrl() ?: '../images/profile-default.jpg';
          ?>
          <img src="<?= htmlspecialchars($avatarUrl) ?>"
               alt="Photo de profil"
               class="profile-img">
        </div>

        <div class="profile-img-container">
          <p class="profile-pseudo"><?= htmlspecialchars($user->getUsername()) ?></p>
          <p class="profile-timer">Membre depuis <?= htmlspecialchars($memberFor) ?></p>
          <p class="profile-counter-title">BIBLIOTHÈQUE</p>
          <p class="profile-counter">
            <i class="fa-solid fa-book"></i> <?= $bookCount ?> livres
          </p>
        </div>

        <!-- 🔹 On écrit au propriétaire du profil, pas à $book['user_id'] -->
        <a href="index.php?action=startConversation&user_id=<?= $user->getId() ?>"
           data-desktop-href="index.php?action=startConversationDesktop&user_id=<?= $user->getId() ?>" 
           class="public-profile-link register-button profile-button public-profile-button">
            Écrire un message
        </a>
      </div>
    </div>
  </div>

  <div class="profile-block-books public-profile-block-books">
    <?php if (empty($books)): ?>
      <p class="profile-book-container">
        Cet utilisateur n’a pas encore ajouté de livres.
      </p>
    <?php else: ?>
      <div class="profile-books-titles-container">
        <div class="profile-books-titles">Photo</div>
        <div class="profile-books-titles">Titre</div>
        <div class="profile-books-titles">Auteur</div>
        <div class="profile-books-titles">Description</div>
      </div>

      <div class="profile-books-colors">
        <?php foreach ($books as $b): ?>
          <div class="profile-book-container">
            <div class="profile-book-title-container public-profile-book-title-container">
              <div class="profile-book-img-container">
                <img src="<?= htmlspecialchars($b->getImage_path() ?? '') ?>"
                     alt="couverture du livre <?= htmlspecialchars($b->getTitle()) ?>"
                     class="profile-book-img">
              </div>

              <div class="profile-book-info-container public-profile-book-info-container">
                <p class="profile-book-title public-profile-book-title">
                  <?= htmlspecialchars($b->getTitle()) ?>
                </p>
                <p class="profile-book-title">
                  <?= htmlspecialchars($b->getAuthor() ?? '') ?>
                </p>
              </div>
            </div>

            <p class="profile-book-description public-profile-book-description">
              <?= nl2br(htmlspecialchars($b->getDescription() ?? '')) ?>
            </p>
          </div>
        <?php endforeach; ?> 
      </div>
    <?php endif; ?>
  </div>
</div>


<script>
  (function () {
    const desktopMq = window.matchMedia('(min-width: 1024px)');
    const link = document.querySelector('.public-profile-link');
    if (!link) return;

    const mobileHref  = link.getAttribute('href');
    const desktopHref = link.getAttribute('data-desktop-href');

    function applyHref() {
      if (desktopMq.matches && desktopHref) {
        link.setAttribute('href', desktopHref);
      } else {
        link.setAttribute('href', mobileHref);
      }
    }

    // au chargement
    applyHref();

    // si on redimensionne la fenêtre
    if (desktopMq.addEventListener) {
      desktopMq.addEventListener('change', applyHref);
    } else if (desktopMq.addListener) { // compat anciens navigateurs
      desktopMq.addListener(applyHref);
    }
  })();
</script>