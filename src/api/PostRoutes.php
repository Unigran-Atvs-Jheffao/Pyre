<?php

namespace Pyre\api;


use Pyre\controllers\UserController;
use Pyre\models\User;
use Pyre\controllers\PostController;
use Pyre\models\Post;

class PostRoutes {
    public static function register($router): void {
        $router->add("GET", "/posts", function () {
            if(isset($_GET["id"])){
                $item = PostController::getInstance()->getById(filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT));
                if($item == null){
                    http_response_code(404);
                    echo json_encode([
                        "error"=>"POST_NOT_FOUND",
                        "msg" => "Post with id '{$_GET["id"]}' not found"
                    ]);
                    return;
                }
                echo json_encode($item);
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
                $json["author"],
                $json["likes"]
            ));

            http_response_code(200);
        });
    }
}