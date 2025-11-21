<?php

namespace App\Controllers;

use App\Models\Repositories\ConversationRepository;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\MessageRepository;
use App\Views\View;
use App\Services\Utils;

class MessageController
{
    private function requiredAuth(): int
    {
        return Utils::requireAuth();
    }

    /**
     * Affiche toutes les conversations existantes.
     */
    public function inbox(): void
    {
        $user_id = $this->requiredAuth();

        $conversationRepo = new ConversationRepository();
        $conversations    = $conversationRepo->conversationList($user_id); // Conversation[]

        $view = new View('Tom Troc - Conversations');
        $view->render('inbox', [
            'conversations' => $conversations,
            'user_id'       => $user_id,
        ]);
    }

    /**
     * Affiche toutes les conversations + messages (desktop).
     */
    public function inboxDesktop(): void
    {
        $user_id = $this->requiredAuth();

        $conversationRepo = new ConversationRepository();
        $conversations    = $conversationRepo->conversationList($user_id); // Conversation[]

        $conversation_id = (int)(Utils::request('id', 0));

        $messages              = [];
        $other_user_id         = null;
        $other_username        = '';
        $other_user_image_url  = null;
        $other_user_avatar     = null;

        if ($conversation_id > 0) {
            $other_user_id = $conversationRepo->getOtherUserId($conversation_id, $user_id);

            if ($other_user_id !== null) {
                // Messages (objets)
                $messageRepo = new MessageRepository();
                $messages    = $messageRepo->getMessages($conversation_id);
                $messageRepo->markMessagesAsRead($conversation_id, $user_id);

                // Infos de l'autre utilisateur
                $userRepo = new UserRepository();
                $other    = $userRepo->findById($other_user_id);
                if ($other) {
                    $other_username       = $other->getUsername();
                    $other_user_image_url = $other->getImageUrl();
                    $other_user_avatar    = $other_user_image_url;
                }
            } else {
                $conversation_id = 0;
            }
        }

        $view = new View('Tom Troc - Messagerie');
        $view->render('inbox_desktop', [
            'conversations'        => $conversations,
            'conversation_id'      => $conversation_id,
            'messages'             => $messages,
            'user_id'              => $user_id,
            'other_user_id'        => $other_user_id,
            'other_username'       => $other_username,
            'other_user_image_url' => $other_user_image_url,
            'other_user_avatar'    => $other_user_avatar,
        ]);
    }

    /**
     * Vue mobile : une conversation spécifique.
     */
    public function showConversation(): void
    {
        $user_id = $this->requiredAuth();

        $conversation_id = (int)(Utils::request('id', 0));
        if ($conversation_id <= 0) {
            Utils::redirect('index.php?action=inbox');
        }

        $conversationRepo = new ConversationRepository();
        $other_user_id    = $conversationRepo->getOtherUserId($conversation_id, $user_id);
        if ($other_user_id === null) {
            Utils::redirect('index.php?action=inbox');
        }

        $userRepo   = new UserRepository();
        $other_user = $userRepo->findById($other_user_id);
        if ($other_user === null) {
            Utils::redirect('index.php?action=inbox');
        }

        $messageRepo = new MessageRepository();
        $messages    = $messageRepo->getMessages($conversation_id);
        $messageRepo->markMessagesAsRead($conversation_id, $user_id);

        $view = new View('Tom Troc - Discussion');
        $view->render('discussion', [
            'messages'        => $messages,                // Message[]
            'conversation_id' => $conversation_id,
            'user_id'         => $user_id,
            'other_user_id'   => $other_user_id,
            'other_username'  => $other_user->getUsername(),
            'other_image_url' => $other_user->getImageUrl(),
        ]);
    }

    /**
     * Nouvelle conversation.
     */
    public function newConversation(): void
    {
        $user_id = $this->requiredAuth();

        $other_user_id = (int)(Utils::request('user_id', 0));
        if ($other_user_id <= 0 || $other_user_id === $user_id) {
            Utils::redirect('index.php?action=inbox');
        }

        $conversationRepo = new ConversationRepository();
        $conversation_id  = $conversationRepo->findOrCreateConversation($user_id, $other_user_id);

        Utils::redirect('index.php?action=conversation&id=' . $conversation_id);
    }

    /**
     * Envoie un message dans une conversation.
     */
    public function sendMessage(): void
    {
        $user_id = $this->requiredAuth();

        if (!Utils::isPost()) {
            Utils::redirect('index.php?action=inbox');
        }

        $conversation_id = (int)(Utils::request('conversation_id', 0));
        $content         = trim((string)(Utils::request('content', '')));
        $context         = trim((string)(Utils::request('context', '')));

        if ($conversation_id <= 0 || $content === '') {
            Utils::redirect('index.php?action=inbox');
        }

        $conversationRepo = new ConversationRepository();
        $other_user_id    = $conversationRepo->getOtherUserId($conversation_id, $user_id);
        if ($other_user_id === null) {
            Utils::redirect('index.php?action=inbox');
        }

        $messageRepo = new MessageRepository();
        $messageRepo->sendMessage($conversation_id, $user_id, $content);
        $conversationRepo->updateConversationTimestamp($conversation_id);

            if ($context === 'desktop') {
                Utils::redirect('index.php?action=inboxDesktop&id=' . $conversation_id);
            } else {
                Utils::redirect('index.php?action=conversation&id=' . $conversation_id);
            }
    }

    
    
    public function newConversationDesktop(): void
    {
        $user_id = $this->requiredAuth();

        $other_user_id = (int)(Utils::request('user_id', 0));
        if ($other_user_id <= 0 || $other_user_id === $user_id) {
            // si param foireux → retour à la messagerie
            Utils::redirect('index.php?action=inboxDesktop');
        }

        $conversationRepo = new ConversationRepository();
        $conversation_id  = $conversationRepo->findOrCreateConversation($user_id, $other_user_id);

        // redirection vers inboxDesktop&id=ID_CONVERSATION
        Utils::redirect('index.php?action=inboxDesktop&id=' . $conversation_id);
    }

}
