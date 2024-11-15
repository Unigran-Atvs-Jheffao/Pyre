<?php
namespace Pyre\controllers;
use Pyre\models\User;
use Pyre\daos\UserDAO;

class UserController {
    private static $instance;
    private $dao;
    private function __construct() {
        $this->dao = new UserDAO();
    }

    public function getById(int $id) {
        return $this->dao->getById($id);
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getByHandle(string $handle) {
        $userData = $this->dao->getByHandle($handle);
        if(!$userData){
            return null;
        }
        $user = new User(
            $userData["username"],
            $userData["handle"],
            $userData["email"],
            $userData["password"],
            $userData["bio"],
            $userData["creation_date"],
            $userData["avatar"]
        );
        $user->setId($userData["id"]);
        return $user;
    }

    public function getByEmail(string $handle) {
        $userData = $this->dao->getByEmail($handle);
        if(!$userData){
            return null;
        }
        $user = new User(
            $userData["username"],
            $userData["handle"],
            $userData["email"],
            $userData["password"],
            $userData["bio"],
            $userData["creation_date"],
            $userData["avatar"]
        );
        $user->setId($userData["id"]);
        return $user;
    }

    public function login(string $handle, string $password) {
        return $this->dao->login($handle, $password);
    }

    public function add($user): void
    {
        $this->dao->add($user);
    }

    public function remove($id) {
        $this->dao->remove($id);
    }
    public function update($json){
        $usr = new User(
            $json["username"],
            $json["at"],
            $json["email"],
            $json["password"],
            $json["bio"],
            $json["creationDate"],
            $json["avatar"]
        );

        $this->dao->update($json["id"],$usr);
    }
    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new UserController();
        }
        return self::$instance;
    }
}