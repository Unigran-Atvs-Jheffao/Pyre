<?php

namespace Pyre\daos;

use PDO;
use Pyre\utils\Hash;
use Pyre\utils\Database;

class UserDAO implements DAO {


    public function __construct()
    {
        Database::getInstance()->exec('
            CREATE TABLE IF NOT EXISTS tbl_pyre_users(
                id integer primary key autoincrement,
                username varchar(32) not null,
                handle varchar(32) not null unique,
                email varchar(128) not null,
                password varchar(64) not null,
                bio varchar(256),
                creation_date timestamp,
                avatar varchar
            )
        ');
    }

    function add($element)
    {
        Database::getInstance()->beginTransaction();
        $statement = Database::getInstance()->prepare(
            'INSERT into tbl_pyre_users(username, handle, email, password, bio, creation_date, avatar) values (?,?,?,?,?,?,?)'
        );

        $statement->bindParam(1, $element->getUsername());
        $statement->bindParam(2, $element->getHandle());
        $statement->bindParam(3, $element->getEmail());
        $statement->bindParam(4, $element->getPassword());
        $statement->bindParam(5, $element->getBio());
        $statement->bindParam(6, $element->getCreationDate());
        $statement->bindParam(7, $element->getAvatar(), PDO::PARAM_LOB);

        $statement->execute();
        Database::getInstance()->commit();
    }

    function remove($id)
    {
        Database::getInstance()->beginTransaction();
        $statement = Database::getInstance()->prepare(
            'DELETE FROM tbl_pyre_users WHERE id = ?'
        );
        $statement->bindParam(1, $id);
        $statement->execute();
        Database::getInstance()->commit();
    }

    function update($id, $element)
    {
        Database::getInstance()->beginTransaction();
        $statement = Database::getInstance()->prepare("UPDATE tbl_pyre_users SET username = ?, handle = ?, email = ?, password = ?, bio = ?, creation_date = ?, avatar = ? where id = ?");
        $statement->bindParam(1, $element->getUsername());
        $statement->bindParam(2, $element->getHandle());
        $statement->bindParam(3, $element->getEmail());
        $statement->bindParam(4, $element->getPassword());
        $statement->bindParam(5, $element->getBio());
        $statement->bindParam(6, $element->getCreationDate());
        $statement->bindParam(7, $element->getAvatar());
        $statement->bindParam(8, $id);
        $statement->execute();
        Database::getInstance()->commit();
    }

    function getById($id)
    {
        $statement = Database::getInstance()->prepare("SELECT * FROM tbl_pyre_users WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch();
    }

    function getAll()
    {
        $statement = Database::getInstance()->prepare("SELECT * FROM tbl_pyre_users");
        $statement->execute();
        return $statement->fetchAll();
    }

    function getByHandle($handle)
    {
        $statement = Database::getInstance()->prepare('SELECT * FROM tbl_pyre_users WHERE "handle" = ?');
        $statement->bindValue(1,$handle);
        if($statement->execute()){
            return $statement->fetch();
        }
        return null;
    }

    function getByEmail($mail)
    {
        $statement = Database::getInstance()->prepare('SELECT * FROM tbl_pyre_users WHERE email = ?');
        $statement->bindValue(1,$mail);
        if($statement->execute()){
            return $statement->fetch();
        }
        return null;
    }

    function login($handle,$password)
    {
        $statement = Database::getInstance()->prepare('SELECT * FROM tbl_pyre_users WHERE handle = ? and password = ?');
        $statement->bindValue(1,$handle);
        $statement->bindValue(2,$password);
        if($statement->execute()){
            return $statement->fetch();
        }
        return null;
    }
}