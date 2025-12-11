<?php

namespace App\Models\Repositories;

use PDO;
use App\Models\Entities\Conversation;
use InvalidArgumentException;

class ConversationRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = DBManager::getInstance()->getPDO();
    }

    public function findOrCreateConversation(int $user1_id, int $user2_id) : int 
    {
        if ($user1_id === $user2_id) {
            throw new InvalidArgumentException("Les deux utilisateurs doivent être différents.");
        }

        $sql = "SELECT id 
                FROM conversations 
                WHERE 
                    (user1_id = :user1_id AND user2_id = :user2_id) OR 
                    (user1_id = :user2_id AND user2_id = :user1_id)
                LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':user1_id' => $user1_id,
            ':user2_id' => $user2_id
        ]);
        $conversation = $statement->fetch();
        if ($conversation) {
            return (int)$conversation['id'];
        }

        $sql = "INSERT INTO conversations (user1_id, user2_id, created_at, updated_at) 
                VALUES (:user1_id, :user2_id, NOW(), NOW())";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':user1_id' => $user1_id,
            ':user2_id' => $user2_id
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Retourne la liste des conversations d'un utilisateur.
     * @param int $user_id : l'id de l'utilisateur.
     * @return Conversation[]
     */
    public function conversationList(int $user_id) : array 
    {
        $sql = "SELECT 
                    c.id,
                    c.user1_id,
                    c.user2_id,
                    c.created_at,
                    c.updated_at,

                    -- utilisateur en face
                    u.id AS other_user_id,
                    u.username AS other_username,
                    u.image_url AS other_image_url,

                    -- dernier message
                    (
                        SELECT m.content
                        FROM messages m
                        WHERE m.conversation_id = c.id
                        ORDER BY m.created_at DESC
                        LIMIT 1
                    ) AS last_message,
                    (
                        SELECT m.created_at
                        FROM messages m
                        WHERE m.conversation_id = c.id
                        ORDER BY m.created_at DESC
                        LIMIT 1
                    ) AS last_message_at

                FROM conversations c
                JOIN users u 
                    ON u.id = CASE 
                                WHEN c.user1_id = :user_id 
                                THEN c.user2_id 
                                ELSE c.user1_id 
                              END
                WHERE c.user1_id = :user_id OR c.user2_id = :user_id
                ORDER BY c.updated_at DESC";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([':user_id' => $user_id]);

        // 🔹 Hydratation en objets Conversation
        $conversations = $statement->fetchAll(PDO::FETCH_CLASS, Conversation::class);

        return $conversations ?: [];
    }

    public function getOtherUserId(int $conversation_id, int $user_id) : ?int
    {
        $sql = "SELECT CASE 
                    WHEN user1_id = :user_id THEN user2_id 
                    WHEN user2_id = :user_id THEN user1_id 
                    ELSE NULL 
                END AS other_user_id
                FROM conversations
                WHERE id = :conversation_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':conversation_id' => $conversation_id,
            ':user_id' => $user_id
        ]);
        $result = $statement->fetch();
        return $result ? (int)$result['other_user_id'] : null;
    }

    public function updateConversationTimestamp(int $conversation_id) : void
    {
        $sql = "UPDATE conversations SET updated_at = NOW() WHERE id = :conversation_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':conversation_id' => $conversation_id]);
    }
}
