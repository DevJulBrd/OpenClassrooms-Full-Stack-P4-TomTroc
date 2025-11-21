<?php

namespace App\Models\Repositories;

use PDO;
use App\Models\Entities\User;

class UserRepository
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBManager::getInstance()->getPDO();
    }

    public function findByEmail(string $email): ?User
    {
        $st = $this->pdo->prepare("SELECT * FROM users WHERE email=:e LIMIT 1");
        $st->execute(['e'=>$email]);
        return $st->fetchObject(User::class) ?: null;
    }

    public function findByUsername(string $username): ?User
    {
        $st = $this->pdo->prepare("SELECT * FROM users WHERE username=:u LIMIT 1");
        $st->execute(['u'=>$username]);
        return $st->fetchObject(User::class) ?: null;
    }

    public function create(string $email, string $username, string $passwordHash): int
    {
        $st = $this->pdo->prepare("
            INSERT INTO users (email, username, password_hash, image_url, created_at)
            VALUES (:e, :u, :ph, NULL, NOW())
        ");
        $st->execute(['e'=>$email, 'u'=>$username, 'ph'=>$passwordHash]);
        return (int)$this->pdo->lastInsertId();
    }


    public function findById(int $id): ?User
    {
        $st = $this->pdo->prepare("SELECT id, email, username, image_url, created_at FROM users WHERE id=:id");
        $st->execute(['id'=>$id]);
        return  $st->fetchObject(User::class) ?: null;
    }

    public function verifyLogin(string $email, string $password): ?User
    {
        $st = $this->pdo->prepare("SELECT * FROM users WHERE email=:e LIMIT 1");
        $st->execute(['e' => $email]);
        $user = $st->fetchObject(User::class);

        if (!$user) return null;
        if (!password_verify($password, $user->getPasswordHash())) return null;

        return $user;
    }

    public function updateImageUrl(int $id, ?string $imageUrl): void
    {
        $st = $this->pdo->prepare("UPDATE users SET image_url=:img WHERE id=:id");
        $st->execute(['img'=>$imageUrl, 'id'=>$id]);
    }
}
