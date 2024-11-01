<?php

namespace Pyre\api\models;
use JsonSerializable;

class Post implements JsonSerializable{
    private $id;
    private $replyTo;
    private $content;
    private $date;
    private $author;
    private $likes;
    /**
     * @param int $id
     * @param string $content
     * @param \DateTime $date
     * @param User $author
     * @param array $tags
     * @param int $likes
     * @param array $replies;
     */
    public function __construct($id, $content, $date, $author, $tags, $likes, $replies)
    {
        $this->id = $id;
        $this->content = $content;
        $this->date = $date;
        $this->author = $author;
        $this->tags = $tags;
        $this->likes = $likes;
        $this->replies = $replies;
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

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    public function getReplies(): array
    {
        return $this->replies;
    }

    public function setReplies(array $replies): void
    {
        $this->replies = $replies;
    }


    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'date' => $this->date,
            'author' => $this->author,
            'tags' => $this->tags,
            'likes' => $this->likes,
            'replies' => $this->replies
        ];
    }
}
