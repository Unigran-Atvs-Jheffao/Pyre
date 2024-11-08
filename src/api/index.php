<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';

use Pyre\api\PostRoutes;
use Pyre\api\Router;
use Pyre\api\UsersRoutes;


$router = Router::getInstance();

UsersRoutes::register($router);
PostRoutes::register($router);

Router::getInstance()->process();