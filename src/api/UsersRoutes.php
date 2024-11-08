<?php

namespace Pyre\api;


use Pyre\controllers\UserController;
use Pyre\models\User;
use Pyre\api\utils\Hash;

class UsersRoutes {
    public static function register($router): void {
        $router->add("POST", "/users/register", function () {
            $json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);


            if(trim($json['handle']) == "" || trim($json['username']) == "" || trim($json['email']) == "" || trim($json['password']) == ""){
                http_response_code(400);
                echo json_encode([
                    "error"=>"INVALID_DATA",
                    "msg" => "Invalid data"
                ]);
                return;
            }

            $data = UserController::getInstance()->getByHandle($json["handle"]);

            if($data != null){
                http_response_code(409);
                echo json_encode([
                    "error"=>"USR_ALREADY_EXISTS_HANDLE",
                    "msg"=>"A user with the handle '{$data->getHandle()}' already exists"
                ]);
                return;
            }

            $data = UserController::getInstance()->getByEmail($json["email"]);

            if($data != null){
                http_response_code(409);
                echo json_encode([
                    "error"=>"USR_ALREADY_EXISTS_EMAIL",
                    "msg"=>"A user with the email '{$data->getEmail()}' already exists"
                ]);
                return;
            }

            UserController::getInstance()->add(new User(
                $json["username"],
                $json["handle"],
                $json["email"],
                $json["password"],
                "",
                date(DATE_ATOM),
                ""
            ));

            http_response_code(200);
            echo json_encode([
                "msg" => "User registered successfully"
            ]);
        });
        $router->add("GET", "/users/profile", function () {
            $data = UserController::getInstance()->getByHandle($_GET["handle"]);
            if($data != null){
                echo json_encode($data);
            } else {
                http_response_code(404);
                echo json_encode([
                    "error" => "USR_DOESNT_EXIST",
                    "msg" => "User with the handle {$_GET["handle"]} doesn't exist"
                ]);
            }
        });
        $router->add("POST", "/users/login", function () {
            $json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);

            $doesUserExist = UserController::getInstance()->getByHandle($json["handle"]);

            if($doesUserExist == null){
                http_response_code(404);
                echo json_encode([
                    "error" => "USR_INVALID",
                    "msg" => "User doesn't exist"
                ]);
            }

            $data = UserController::getInstance()->login($json["handle"], $json["password"]);

            if($data != null){
                session_start();
                $_SESSION["token"] = Hash::hashPassword($data["handle"]);
                http_response_code(200);
                echo json_encode([
                    "msg" => "User logged in",
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    "error" => "LOGIN_FAILED",
                    "msg" => "Handle and/or password invalid"
                ]);
            }
        });
        $router->add("DELETE", "/users/delete", function () {
            $json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);

            UserController::getInstance()->delete($json["id"]);
        });
        $router->add("UPDATE", "/users/update", function () {
            $json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);

            UserController::getInstance()->update($json);
        });
    }
}