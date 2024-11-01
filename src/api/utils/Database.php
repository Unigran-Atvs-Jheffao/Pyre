<?php

namespace Pyre\utils;

use PDO;

class Database {
    static private $instance;

    /**
     * @return PDO
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new PDO("sqlite:".$_SERVER['DOCUMENT_ROOT']."/pyre.db");
        }
        return self::$instance;
    }


}