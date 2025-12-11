<?php

namespace App\Models\Repositories;

use PDO;
use App\Models\Entities\Message;

class MessageRepository 
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBManager::getInstance()->getPDO();
    }

    /**
     * Envoie un message dans une conversation.
     * @return int id du message
     */
    public function sendMessage(int $conversation_id, int $sender_id, string $content): int
    {
        $sql = "INSERT INTO messages (conversation_id, sender_id, content, created_at, read_at) 
                VALUES (:conversation_id, :sender_id, :content, NOW(), NULL)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':conversation_id' => $conversation_id,
            ':sender_id'       => $sender_id,
            ':content'         => $content,
        ]);

        // Mise à jour du updated_at de la conversation
        $sql = "UPDATE conversations SET updated_at = NOW() WHERE id = :conversation_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':conversation_id' => $conversation_id,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Retourne la liste des messages d'une conversation sous forme d'objets Message.
     * @return Message[]
     */
    public function getMessages(int $conversation_id): array
    {
        $sql = "SELECT 
                    m.id,
                    m.conversation_id,
                    m.sender_id,
                    m.content,
                    m.created_at,
                    m.read_at,
                    u.username AS sender_username
                FROM messages m
                JOIN users u ON m.sender_id = u.id
                WHERE m.conversation_id = :conversation_id
                ORDER BY m.created_at ASC";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([':conversation_id' => $conversation_id]);

        // 🔹 objets App\Models\Entities\Message
        $messages = $statement->fetchAll(PDO::FETCH_CLASS, Message::class);

        return $messages ?: [];
    }

    /**
     * Marque les messages d'une conversation comme lus pour un utilisateur donné.
     */
    public function markMessagesAsRead(int $conversation_id, int $user_id): void
    {
        $sql = "UPDATE messages 
                SET read_at = NOW() 
                WHERE conversation_id = :conversation_id 
                  AND sender_id != :user_id 
                  AND read_at IS NULL";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':conversation_id' => $conversation_id,
            ':user_id'         => $user_id,
        ]);
    }

    /**
     * Compte les messages non lus pour un utilisateur.
     */
    public function countUnread(int $user_id): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM messages m
            JOIN conversations c ON c.id = m.conversation_id
            WHERE (c.user1_id = :uid OR c.user2_id = :uid)
              AND m.sender_id <> :uid
              AND m.read_at IS NULL
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':uid' => $user_id]);

        return (int)$statement->fetchColumn();
    }
}
