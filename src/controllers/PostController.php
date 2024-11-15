<?php
namespace Pyre\controllers;
use Pyre\daos\PostDAO;
use Pyre\models\Post;

class PostController{
    private static $instance;
    private $dao;

    private function __construct() {
        $this->dao = new PostDAO();
    }

    public function getById(int $id) {
        return $this->dao->getById($id);
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function add($post): void
    {
        $this->dao->add($post);
    }

    public function remove($id) {
        $this->dao->remove($id);
    }
    public function update($json){
        $post = new Post(
            $json["content"],
            $json["date"],
            $json["author"],
        );

        $this->dao->update($json["id"],$post);
    }
    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new PostController();
        }
        return self::$instance;
    }
}