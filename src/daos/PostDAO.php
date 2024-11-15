<?php

namespace Pyre\daos;
use Pyre\utils\Database;

class PostDAO implements DAO{
    public function __construct()
    {
        Database::getInstance()->exec('
            CREATE TABLE IF NOT EXISTS tbl_pyre_posts(
                id integer primary key autoincrement,
                author integer not null,
                content varchar(512),
                likes integer
            )
        ');
    }
    function add($element)
    {
        try{
            $statement = Database::getInstance()->prepare("INSERT INTO tbl_pyre_posts(author,content,likes) values (?,?,?)");
            $statement->bindValue(1,$element->getAuthor());
            $statement->bindValue(2,$element->getContent());
            $statement->bindValue(3,$element->getLikes());

            $statement->execute();

        }catch (\Throwable $t){
            http_response_code(500);
            print_r($t);
        }
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


    function getAllOffset($offset = 0)
    {
        $statement = Database::getInstance()->prepare("SELECT * FROM tbl_pyre_posts LIMIT 10 OFFSET $offset");
        $statement->execute();
        return $statement->fetchAll();
    }
}