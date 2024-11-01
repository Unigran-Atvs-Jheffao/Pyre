<?php
namespace Pyre\api\utils;

class Hash {
    static private $SALT = "pyrite";

    public static function hashPassword($password){
        return password_hash(self::$SALT . $password, PASSWORD_DEFAULT);
    }
}

