<section class="conversation-layout">

  <!-- COLONNE GAUCHE : liste des conversations -->
  <aside class="conversation-sidebar">
    <h1 class="conversation-title">Messagerie</h1>

    <?php if (empty($conversations)): ?>
      <p>Aucune conversation trouvée.</p>
    <?php else: ?>
      <div class="conversation-container">
        <?php foreach ($conversations as $conversation): ?>
          <?php
            /** @var \App\Models\Entities\Conversation $conversation */
            $cid       = (int)$conversation->getId();
            $isActive  = isset($conversation_id) && $cid === (int)$conversation_id;

            $avatarUrl = $conversation->getOtherImageUrl() ?: '../../images/profile-default.jpg';
            $username  = $conversation->getOtherUsername() ?? '';
            $lastMsg   = $conversation->getLastMessage() ?? 'Aucun message';

            $rawDate = $conversation->getLastMessageAt() ?? $conversation->getUpdated_at();
          ?>
          <div class="conversation-item <?= $isActive ? 'conversation-item-active' : '' ?>">
            <a
              href="index.php?action=conversation&id=<?= htmlspecialchars($cid) ?>"
              data-desktop-href="index.php?action=inboxDesktop&id=<?= htmlspecialchars($cid) ?>"
              class="conversation-link"
            >
              <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="Avatar" class="conversation-img">
              <div class="conversation-message">
                <p class="conversation-name"><?= htmlspecialchars($username) ?></p>
                <p class="conversation-text"><?= htmlspecialchars($lastMsg) ?></p>
              </div>
              <p class="conversation-name">
                <?php
                if ($rawDate) {
                    $dt  = new DateTime($rawDate);
                    $now = new DateTime('now');

                    if ($dt->format('Y-m-d') === $now->format('Y-m-d')) {
                        echo htmlspecialchars($dt->format('H:i'));
                    } else {
                        echo htmlspecialchars($dt->format('d/m'));
                    }
                } else {
                    echo '';
                }
                ?>
              </p>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </aside>

  <!-- COLONNE DROITE : conversation -->
  <section class="conversation-main">
    <?php if (empty($conversation_id) || $other_user_id === null): ?>
      <div class="discution-container discution-empty">
        <p>Sélectionnez une conversation pour commencer.</p>
      </div>
    <?php else: ?>

      <div class="discution-container">
        <div>
          <a href="index.php?action=publicProfile&user_id=<?= htmlspecialchars($other_user_id); ?>"
            class="discution-otherUserInfo">
            <img
              src="<?= htmlspecialchars($other_user_image_url ?? '../../images/profile-default.jpg') ?>"
              alt="Avatar"
              class="discussion-otherUserImg"
            >
            <p class="discussion-otherUser"><?= htmlspecialchars($other_username) ?></p>
          </a>
        </div>

        <div class="discussion-messages-container" id="messagesContainer">
          <?php if (empty($messages)): ?>
            <p>Aucun message dans cette conversation.</p>
          <?php else: ?>
            <?php foreach ($messages as $message): ?>
              <?php
                /** @var \App\Models\Entities\Message $message */
                $isSent = ($message->getSender_id() === $user_id);

                $formattedDate = '';
                if ($message->getCreated_at()) {
                    $dt = new DateTime($message->getCreated_at());
                    $formattedDate = htmlspecialchars($dt->format('d.m H:i'));
                }

                $avatarUrl = $other_user_avatar ?? ($other_user_image_url ?? '../images/profile-default.jpg');
              ?>

              <div class="message-item <?= $isSent ? 'sent' : 'received'; ?>">

                <?php if ($isSent): ?>
                  <!-- MESSAGE ENVOYÉ -->
                  <div class="message-bubble sent-bubble">
                    <span class="message-time">
                      <?= $formattedDate; ?>
                    </span>
                    <p class="message-text message-sent">
                      <?= htmlspecialchars($message->getContent()); ?>
                    </p>
                  </div>

                <?php else: ?>
                  <!-- MESSAGE REÇU -->
                  <div class="message-bubble received-bubble">
                    <div class="message-header">
                      <a href="index.php?action=publicProfile&user_id=<?= htmlspecialchars($other_user_id); ?>">
                        <img
                          src="<?= htmlspecialchars($avatarUrl); ?>"
                          alt="avatar"
                          class="message-avatar"
                        >
                      </a>
                      <span class="message-time">
                        <?= $formattedDate; ?>
                      </span>
                    </div>
                    <p class="message-text message-received">
                      <?= htmlspecialchars($message->getContent()); ?>
                    </p>
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div>
          <form method="post" action="index.php?action=sendMessage" class="discussion-message-form">
            <input type="hidden" name="conversation_id" value="<?= htmlspecialchars($conversation_id); ?>">
            <input type="hidden" name="context" value="desktop">
            <textarea name="content" placeholder="Tapez votre message ici" class="discussion-input" required></textarea>
            <button type="submit" class="home-button-present dicussion-button discussion-desktop">Envoyer</button>
          </form>
        </div>
      </div>

      <script>
        (function () {
          const el = document.getElementById('messagesContainer');
          if (el) el.scrollTop = el.scrollHeight;
        })();
      </script>
    <?php endif; ?>
  </section>

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
        link.setAttribute('href', desktopHref);
      } else {
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
