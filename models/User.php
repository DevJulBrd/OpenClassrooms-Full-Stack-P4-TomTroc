<?php
class User
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBManager::getInstance()->getPDO();
    }

    public function findByEmail(string $email): ?array
    {
        $st = $this->pdo->prepare("SELECT * FROM users WHERE email=:e LIMIT 1");
        $st->execute(['e'=>$email]);
        return $st->fetch() ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $st = $this->pdo->prepare("SELECT * FROM users WHERE username=:u LIMIT 1");
        $st->execute(['u'=>$username]);
        return $st->fetch() ?: null;
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


    public function findById(int $id): ?array
    {
        $st = $this->pdo->prepare("SELECT id, email, username, image_url, created_at FROM users WHERE id=:id");
        $st->execute(['id'=>$id]);
        return $st->fetch() ?: null;
    }

    public function verifyLogin(string $email, string $password): ?array
    {
        $st = $this->pdo->prepare("SELECT * FROM users WHERE email=:e LIMIT 1");
        $st->execute(['e' => $email]);
        $user = $st->fetch();

        if (!$user) return null;
        if (!password_verify($password, $user['password_hash'])) return null;

        return $user;
    }

}
