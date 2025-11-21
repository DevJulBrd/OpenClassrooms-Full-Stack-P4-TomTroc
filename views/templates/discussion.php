<div class="discution-container">
    <a href="index.php?action=inbox" class="discution-goBack"><- retour</a>
    <div>
        <a href="index.php?action=publicProfile&user_id=<?= htmlspecialchars($other_user_id); ?>"  class="discution-otherUserInfo" >
            <img src="<?= htmlspecialchars($other_image_url ?? '../../images/profile-default.jpg') ?>" alt="Avatar" class="discussion-otherUserImg">
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

                    $avatarUrl = $other_user_image_url ?? '../images/profile-default.jpg';
                ?>

                <div class="message-item <?= $isSent ? 'sent' : 'received'; ?>">

                    <?php if ($isSent): ?>
                        <!-- MESSAGE ENVOYÉ PAR MOI -->
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
                                <a href="index.php?action=publicProfile&user_id=<?= htmlspecialchars($other_user_id); ?>" >
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
            <textarea name="content" placeholder="Tapez votre message ici" class="discussion-input" required></textarea>
            <button type="submit" class="home-button-present dicussion-button">Envoyer</button>
        </form>
    </div>
    <script>
        (function () {
            const el = document.getElementById('messagesContainer');
            if (el) el.scrollTop = el.scrollHeight;
        })();
    </script>
</div>
