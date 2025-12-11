<?php

namespace App\Models\Repositories;

use PDO;
use App\Models\Entities\Book;

class BookRepository
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBManager::getInstance()->getPDO();
    }

    /**
     * Récupère la totalité des livres
     * @return Book[]
     */
    public function bookList() : array
    {
        $sql="SELECT b.id, b.user_id, b.title, b.author, b.image_path, b.created_at, u.username
                FROM books AS b
                INNER JOIN users AS u ON b.user_id = u.id
                ORDER BY created_at DESC";
        $st = $this->pdo->prepare($sql);
        $st->execute();
        $books = $st->fetchAll(PDO::FETCH_CLASS, Book::class);
        return $books ?: [];
    }

    /**
     * Recherche des livres par titre
     * @param string $q Value searchbar
     * @return Book[]
     */
    public function searchByTitle(string $q): array
    {
        $sql = "SELECT b.id, b.user_id, b.title, b.author, b.image_path, b.created_at, u.username
                FROM books AS b
                INNER JOIN users AS u ON b.user_id = u.id
                WHERE b.title LIKE :q
                ORDER BY created_at DESC";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(':q', '%' . $q . '%', PDO::PARAM_STR);
        $st->execute();

        $books = $st->fetchAll(PDO::FETCH_CLASS, Book::class);
        return $books ?: [];
    }

    public function bookByID(int $id): ?Book
    {
        $sql = "SELECT 
                b.id,
                b.user_id,
                b.title,
                b.author,
                b.image_path,
                b.description,
                b.status,
                u.username,
                u.image_url
            FROM books AS b
            INNER JOIN users AS u ON b.user_id = u.id
            WHERE b.id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':id', $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchObject(Book::class) ?: null;
    }

    /**
     * Récupère les 4 derniers livres ajoutés en fonction de 'created_at' pour la page d'accueil
     * @param int $offset Décalage pour la pagination
     * @param int $limit Nombre de livres à récupérer
     * @return array<int, array<string, mixed>> Liste des livres 
     */
    public function bookListHome(int $offset, int $limit) : array
    {
        $sql = "SELECT b.id, b.user_id, b.title, b.author, b.image_path, b.created_at, u.username
                FROM books AS b
                INNER JOIN users AS u ON b.user_id = u.id
                ORDER BY created_at DESC
                LIMIT :o, :l";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':o', $offset, PDO::PARAM_INT);
        $st->bindValue(':l', $limit, PDO::PARAM_INT);
        $st->execute();

        $books = $st->fetchAll(PDO::FETCH_CLASS, Book::class);
        return $books ?: [];
    }

    /**
     * Récupère tous les livres d'un utilisateur
     * @param int $userId
     * @return Book[]
     */
    public function listByUser(int $userId): array
    {
        $sql = "SELECT 
                    id, 
                    user_id, 
                    title, 
                    author, 
                    description, 
                    image_path, 
                    status, 
                    created_at, 
                    updated_at
                FROM books
                WHERE user_id = :u
                ORDER BY created_at DESC";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':u', $userId, PDO::PARAM_INT);
        $st->execute();
        
        // 🔹 ICI la vraie ligne manquante :
        $books = $st->fetchAll(PDO::FETCH_CLASS, Book::class);

        return $books ?: [];
    }

    public function countByUser(int $userId): int
    {
        $st = $this->pdo->prepare("SELECT COUNT(*) FROM books WHERE user_id = :u");
        $st->execute(['u' => $userId]);
        return (int)$st->fetchColumn();
    }

    public function deleteOwned(int $bookId, int $ownerId): bool
    {
        $st = $this->pdo->prepare("DELETE FROM books WHERE id = :id AND user_id = :u");
        $st->execute(['id' => $bookId, 'u' => $ownerId]);
        return $st->rowCount() > 0;
    }

    /**
     * Vérifie si utilisateur est le propriétaire du livre
     * @param int $bookId, l'id du livre que l'on veut modifier
     * @param int $ownerId, l'id du propriétaire du livre
     * @return bool true / false
     */
    public function isOwner(int $bookId, int $ownerId) : bool
    {
        $statment = $this->pdo->prepare("SELECT 1 FROM books WHERE id = :id AND user_id = :uid");
        $statment->execute([':id' => $bookId, ':uid' => $ownerId]);
        return (bool)$statment->fetchColumn();
    }

    /**
     * Modification d'un livre par son propriétaire
     * @param int $bookId, l'id du livre que l'on veut modifier
     * @param int $ownerId, l'id du propriétaire du livre
     * @param array $fields, valeur des champs initial 
     */
    public function updateByOwner(int $bookId, int $ownerId, array $fields) : bool 
    {
        if(!$this->isOwner($bookId, $ownerId)) {
            return false;
        }

        $sets = [];
        $params = [':id' => $bookId];

        foreach ($fields as $champ => $value) {
            $sets[] = "$champ = :$champ";
            $params[":$champ"] = $value;
        }

        if (!$sets) return true; // si false rien à modifier 

        $sql = "UPDATE books SET " . implode(', ', $sets) . " WHERE id = :id";
        $statment = $this->pdo->prepare($sql);
        return $statment->execute($params);
    }
}
