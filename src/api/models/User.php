<?php

namespace Pyre\api\models;
use JsonSerializable;

class User implements JsonSerializable{
    private $id;
    private $username;
    private $handle;
    private $email;
    private $password;
    private $bio;
    private $creationDate;
    private $avatar;

    /**
     * @param $username
     * @param $at
     * @param $email
     * @param $password
     * @param $bio
     * @param $creationDate
     * @param $avatar
     */
    public function __construct($username, $at, $email, $password, $bio, $creationDate, $avatar)
    {
        $this->username = $username;
        $this->handle = $at;
        $this->email = $email;
        $this->password = $password;
        $this->bio = $bio;
        $this->creationDate = $creationDate;
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     */
    public function setHandle($handle): void
    {
        $this->handle = $handle;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio): void
    {
        $this->bio = $bio;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }


    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "handle" => $this->handle,
            "email" => $this->email,
            "password" => $this->password,
            "bio" => $this->bio,
            "creationDate" => $this->creationDate,
            "avatar" => $this->avatar
        ];
    }
}