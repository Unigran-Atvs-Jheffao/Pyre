<?php
namespace Pyre\utils;

class Hash {
    static private $SALT = "pyrite";

    public static function ashPassword($password){
        return password_hash(self::$SALT . $password, PASSWORD_DEFAULT);
    }
}

