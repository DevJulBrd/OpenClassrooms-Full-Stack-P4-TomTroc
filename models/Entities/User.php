<?php

namespace App\Models\Entities;

class User
{
    private int $id;
    private string $email;
    private string $password_hash;
    private string $username;
    private ?string $image_url;
    private string $created_at;

    /**
     * Get the value of id
     */ 
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of passwordHash
     */ 
    public function getPasswordHash() : string
    {
        return $this->password_hash;
    }

    /**
     * Set the value of passwordHash
     *
     * @return  self
     */ 
    public function setPasswordHash(string $passwordHash) : self
    {
        $this->password_hash = $passwordHash;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of imageUrl
     */ 
    public function getImageUrl() : ?string
    {
        return $this->image_url;
    }

    /**
     * Set the value of imageUrl
     *
     * @return  self
     */ 
    public function setImageUrl(?string $imageUrl) : self 
    {
        $this->image_url = $imageUrl;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(string $createdAt) : self
    {
        $this->created_at = $createdAt;

        return $this;
    }
}