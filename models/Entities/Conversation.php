<?php

namespace App\Models\Entities;

class Conversation
{
    private int $id;
    private int $user1_id;
    private int $user2_id;
    private string $created_at;
    private string $updated_at;

    // 🔹 Champs "dérivés" utilisés dans conversationList()
    private ?int $other_user_id = null;
    private ?string $other_username = null;
    private ?string $other_image_url = null;
    private ?string $last_message = null;
    private ?string $last_message_at = null;

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */ 
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUser1_id(): int
    {
        return $this->user1_id;
    }

    public function setUser1_id(int $user1_id): self
    {
        $this->user1_id = $user1_id;
        return $this;
    }

    public function getUser2_id(): int
    {
        return $this->user2_id;
    }

    public function setUser2_id(int $user2_id): self
    {
        $this->user2_id = $user2_id;
        return $this;
    }

    public function getCreated_at(): string
    {
        return $this->created_at;
    }

    public function setCreated_at(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdated_at(): string
    {
        return $this->updated_at;
    }

    public function setUpdated_at(string $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    // ---------- Champs dérivés ----------

    public function getOtherUserId(): ?int
    {
        return $this->other_user_id;
    }

    public function setOtherUserId(?int $other_user_id): self
    {
        $this->other_user_id = $other_user_id;
        return $this;
    }

    public function getOtherUsername(): ?string
    {
        return $this->other_username;
    }

    public function setOtherUsername(?string $other_username): self
    {
        $this->other_username = $other_username;
        return $this;
    }

    public function getOtherImageUrl(): ?string
    {
        return $this->other_image_url;
    }

    public function setOtherImageUrl(?string $other_image_url): self
    {
        $this->other_image_url = $other_image_url;
        return $this;
    }

    public function getLastMessage(): ?string
    {
        return $this->last_message;
    }

    public function setLastMessage(?string $last_message): self
    {
        $this->last_message = $last_message;
        return $this;
    }

    public function getLastMessageAt(): ?string
    {
        return $this->last_message_at;
    }

    public function setLastMessageAt(?string $last_message_at): self
    {
        $this->last_message_at = $last_message_at;
        return $this;
    }
}
