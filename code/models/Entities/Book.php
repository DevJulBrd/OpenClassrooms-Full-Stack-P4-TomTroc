<?php

namespace App\Models\Entities;

class Book
{
    private int $id;
    private int $user_id;
    private string $username;
    private ?string $image_url;
    private string $title;
    private string $author;
    private string $description;
    private ?string $image_path;
    private string $status;
    private string $created_at;
    private string $updated_at;
    

    /**
     * Get the value of id
     */ 
    public function getId() :int
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
     * Get the value of user_id
     */ 
    public function getUser_id() : int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id(int $user_id) : self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor() : string
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor(string $author) : self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of image_path
     */ 
    public function getImage_path() : ?string
    {
        return $this->image_path;
    }

    /**
     * Set the value of image_path
     *
     * @return  self
     */ 
    public function setImage_path(string $image_path) : self
    {
        $this->image_path = $image_path;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus(string $status) : self
    {
        $this->status = $status;
        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isUnavailable(): bool
    {
        return $this->status === 'unavailable';
    }

    public function isReserved(): bool
    {
        return $this->status === 'reserved';
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at() : string
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at(string $created_at) : self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at() : string
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at(string $updated_at) : self
    {
        $this->updated_at = $updated_at;

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
     * Get the value of image_url
     */ 
    public function getImage_url() : ?string
    {
        return $this->image_url;
    }

    /**
     * Set the value of image_url
     *
     * @return  self
     */ 
    public function setImage_url(?string $image_url) : self
    {
        $this->image_url = $image_url;

        return $this;
    }
}