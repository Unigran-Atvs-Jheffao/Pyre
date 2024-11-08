<?php

namespace Pyre\daos;
use Pyre\utils\Database;

class PostDAO implements DAO{
    public function __construct()
    {
        Database::getInstance()->exec('
            CREATE TABLE IF NOT EXISTS tbh_pyre_posts(
                id integer primary key autoincrement,
                reply_to integer,
                creation_date timestamp not null,
                author integer not null,
                content varchar(512),
                likes integer
            )
        ');
    }
    function add($element)
    {
        Database::getInstance()->beginTransaction();
        $statement = Database::getInstance()->prepare("INSERT INTO tbl_pyre_posts(reply_to,creation_date,author,content,likes) values (?,?,?,?,?)");
        $statement->bindValue(1,$element->getReplyTo());
        $statement->bindValue(2,$element->getCreationDate());
        $statement->bindValue(3,$element->getAuthor());
        $statement->bindValue(4,$element->getContent());
        $statement->bindValue(5,$element->getLikes());

        $statement->execute();
        Database::getInstance()->commit();
    }

    function remove($id)
    {
        Database::getInstance()->beginTransaction();
        $statement = Database::getInstance()->prepare("DELETE FROM tbl_pyre_posts where id = ?");
        $statement->bindParam(1, $id->getId());
        $statement->execute();
        Database::getInstance()->commit();
    }

    function update($id, $element)
    {
        Database::getInstance()->beginTransaction();
        $statement = Database::getInstance()->prepare("UPDATE tbl_pyre_posts SET reply_to = ?,creation_date = ?,author = ?,content = ?,likes =? where id = ?");
        $statement->bindValue(1,$element->getReplyTo());
        $statement->bindValue(2,$element->getCreationDate());
        $statement->bindValue(3,$element->getAuthor());
        $statement->bindValue(4,$element->getContent());
        $statement->bindValue(5,$element->getLikes());
        $statement->bindParam(6, $id);
        $statement->execute();
        Database::getInstance()->commit();
    }

    function getById($id)
    {
        $statement = Database::getInstance()->prepare("SELECT * FROM tbl_pyre_posts WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch();
    }

    function getAll()
    {
        $statement = Database::getInstance()->prepare("SELECT * FROM tbl_pyre_posts");
        $statement->execute();
        return $statement->fetchAll();
    }
}