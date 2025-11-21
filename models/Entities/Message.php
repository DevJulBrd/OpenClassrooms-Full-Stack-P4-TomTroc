<?php

namespace App\Models\Entities;

class Message
{
    private int $id;
    private int $conversation_id;
    private int $sender_id;
    private string $content;
    private string $created_at;
    private ?string $read_at = null;
    
    private ?string $sender_username = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getConversation_id(): int
    {
        return $this->conversation_id;
    }

    public function setConversation_id(int $conversation_id): self
    {
        $this->conversation_id = $conversation_id;
        return $this;
    }

    public function getSender_id(): int
    {
        return $this->sender_id;
    }

    public function setSender_id(int $sender_id): self
    {
        $this->sender_id = $sender_id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
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

    public function getRead_at(): ?string
    {
        return $this->read_at;
    }

    public function setRead_at(?string $read_at): self
    {
        $this->read_at = $read_at;
        return $this;
    }

    public function getSenderUsername(): ?string
    {
        return $this->sender_username;
    }

    public function setSender_username(?string $sender_username): self
    {
        $this->sender_username = $sender_username;
        return $this;
    }
}
