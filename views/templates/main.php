<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'TomTroc') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./css/style.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>  
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">  
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</head>
<body>
<header class="header">
  <img src="./images/logo.png" alt="Logo TomTroc" class="logo">

  <input type="checkbox" id="menu-toggle" class="menu-toggle" aria-hidden="true">
  <label for="menu-toggle" class="menu-trigger">
    <i class="fa-solid fa-bars"></i>
  </label>

  <nav id="primary-nav" class="nav">
    <div>
        <a href="index.php">Accueil</a>
        <a href="index.php?action=books">Nos livres à l'échange</a>
    </div> 
    <div>
        <a href="index.php?action=inbox" data-desktop-href="index.php?action=inboxDesktop" class="nav-link-messages">
            <i class="fa-regular fa-message"></i>
            Messagerie
            <?php if(!empty($unreadCount)): ?>
              <span class="message-count"><?= (int)$unreadCount ?></span>
            <?php endif; ?>
        </a>
        <a href="index.php?action=profile">
            <i class="fa-regular fa-user"></i>
            Mon compte
        </a>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <a href="index.php?action=logout">Déconnexion</a>
        <?php else: ?>
          <a href="index.php?action=login">Connexion</a>
        <?php endif; ?>
    </div>
  </nav>
</header>

  <main>
    <?= $content ?? '' ?>
  </main>

  <footer class="footer">
    <nav class="footer-nav">
        <a href="#">Politique de confidentualité</a>
        <a href="#">Mentions légales</a>
        <a href="#">Tom Troc©</a>
        <img src="./images/logoFooter.png" alt="Logo TomTroc" class="footer-logo">
    </nav>
  </footer>

<script>
  (function () {
    const desktopMq = window.matchMedia('(min-width: 1024px)');
    const link = document.querySelector('.nav-link-messages');
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
</body>
</html>