<?php

namespace Pyre\api;


use Pyre\api\controllers\UserController;
use Pyre\api\models\User;
use Pyre\controllers\PostController;
use Pyre\models\Post;

class PostRoutes {
    public static function register($router): void {
        $router->add("GET", "/posts", function () {
            if(isset($_GET["id"])){
                echo json_encode(PostController::getInstance()->getById(filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT)));
            }else{
                echo json_encode(PostController::getInstance()->getAll());
            }
        });
        $router->add("DELETE", "/posts", function () {
            $json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);

            PostController::getInstance()->remove($json["id"]);
        });
        $router->add("UPDATE", "/posts", function () {
            $json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);

            PostController::getInstance()->update($json);
        });
        $router->add("POST", "/posts", function () {
            $json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);

            PostController::getInstance()->add(new Post(
                $json["content"],
                $json["date"],
                $json["author"],
                $json["tags"],
                $json["likes"],
                $json["replies"]
            ));
        });
    }
}