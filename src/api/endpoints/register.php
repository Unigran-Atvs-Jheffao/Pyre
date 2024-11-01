<?php
namespace Pyre\api\endpoints;
use Pyre\api\controllers\UserController;
use Pyre\api\models\User;

header("Content-Type: application/json");

require_once $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';
$json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);


if(trim($json['handle']) == "" || trim($json['username']) == "" || trim($json['email']) == "" || trim($json['password']) == ""){
    echo json_encode([
        "error"=>"INVALID_DATA",
        "msg" => "Invalid data"
    ]);
    return;
}

$data = UserController::getInstance()->getByHandle($json["handle"]);

if($data != null){
    echo json_encode([
        "error"=>"USR_ALREADY_EXISTS_HANDLE",
        "msg"=>"A user with the handle '{$data->getHandle()}' already exists"
    ]);
    return;
}

$data = UserController::getInstance()->getByEmail($json["email"]);

if($data != null){
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

echo "{}";