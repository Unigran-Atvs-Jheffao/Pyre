<?php
namespace Pyre\api\endpoints;
use Pyre\api\controllers\UserController;

header("Content-Type: application/json");

require_once $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';
$json = json_decode(file_get_contents('php://input'), $flags=JSON_OBJECT_AS_ARRAY);
$data = UserController::getInstance()->getByHandle($json["handle"]);
echo json_encode($data);

