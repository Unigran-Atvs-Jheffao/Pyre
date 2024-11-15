<?php

namespace Pyre\models;
use JsonSerializable;

class Post implements JsonSerializable{
    private $id;
    private $content;
    private $author;
    private $likes;
    /**
     * @param $content
     * @param int $author
     * @param int $likes
     */
    public function __construct($content, $author, $likes)
    {
        $this->content = $content;
        $this->author = $author;
        $this->likes = $likes;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): int
    {
        return $this->author;
    }

    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }


    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'author' => $this->author,
            'likes' => $this->likes,
        ];
    }
}
