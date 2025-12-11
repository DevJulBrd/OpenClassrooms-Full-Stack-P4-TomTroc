<section class="bookid-container">
    <div class="bookid-img-container">
        <img src="<?= htmlspecialchars($book->getImage_path() ?? '') ?>" 
             alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>" 
             class="bookid-img">
    </div>
    <div class="bookid-info-container">
        <h2 class="home-title-present bookid-title"><?= htmlspecialchars($book->getTitle()) ?></h2>
        <p class="bookid-author">par <?= htmlspecialchars($book->getAuthor()) ?></p>
        <div class="bookid-line"></div>
        <p class="bookid-description-title">Description</p>
        <p class="bookid-description"><?= htmlspecialchars($book->getDescription()) ?></p>

        <p class="bookid-description-title">Propriétaire</p>
        <div class="bookid-owner-container">
            <div class="bookid-owner-img-container">
                <?php if ($book->getImage_url() === null): ?>
                    <a href="index.php?action=publicProfile&user_id=<?= (int)$book->getUser_id() ?>">
                        <img src="../images/profile-default.jpg" alt="Tête avatar par default" class="bookid-owner-img">
                    </a>
                <?php else: ?>
                    <a href="index.php?action=publicProfile&user_id=<?= (int)$book->getUser_id() ?>">
                        <img src="<?= htmlspecialchars($book->getImage_url()) ?>" 
                             alt="Avatar de profile de l'utilisateur" 
                             class="bookid-owner-img">
                    </a>
                <?php endif; ?>
            </div>
            <p class="bookid-owner-name"><?= htmlspecialchars($book->getUsername()) ?></p>
        </div>

        <a href="index.php?action=startConversation&user_id=<?= htmlspecialchars($book->getUser_id()) ?>" 
           data-desktop-href="index.php?action=startConversationDesktop&user_id=<?= htmlspecialchars($book->getUser_id()) ?>" 
           class="home-link-button-present bookid-button conversation-link home-button-present">
          Envoyer un message
        </a> 
    </div>
</section>



<script>
(function () {
  const mq = window.matchMedia('(min-width: 1024px)');
  const links = document.querySelectorAll('.conversation-link');

  function apply() {
    links.forEach(link => {
      const mobileHref  = link.getAttribute('href');
      const desktopHref = link.getAttribute('data-desktop-href');
      if (!desktopHref) return;

      if (mq.matches) {
        // desktop → layout split
        link.setAttribute('href', desktopHref);
      } else {
        // mobile → page conversation classique
        link.setAttribute('href', mobileHref);
      }
    });
  }

  if (links.length) {
    apply();
    if (mq.addEventListener) {
      mq.addEventListener('change', apply);
    } else if (mq.addListener) {
      mq.addListener(apply);
    }
  }
})();
</script>