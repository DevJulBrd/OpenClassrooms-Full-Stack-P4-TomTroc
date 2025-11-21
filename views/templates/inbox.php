<h1 class="conversation-title">Messagerie</h1>

<?php if (empty($conversations)): ?>
  <p>Aucune conversation trouvée.</p>
<?php else: ?>
  <div class="conversation-container">
    <?php foreach ($conversations as $conversation): ?>
      <?php
        // $conversation est un objet App\Models\Entities\Conversation
        $cid       = (int)$conversation->getId();
        $avatarUrl = $conversation->getOtherImageUrl() ?: '../../images/profile-default.jpg';
        $username  = $conversation->getOtherUsername() ?? '';
        $lastMsg   = $conversation->getLastMessage() ?? 'Aucun message';

        // date : dernier message ou updated_at
        $rawDate = $conversation->getLastMessageAt() ?? $conversation->getUpdated_at();
      ?>
      <div class="conversation-item">
        <a href="index.php?action=conversation&id=<?= htmlspecialchars($cid) ?>" class="conversation-link">
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
                    // même jour → heure
                    echo htmlspecialchars($dt->format('H:i'));
                } else {
                    // autre jour → date courte
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
