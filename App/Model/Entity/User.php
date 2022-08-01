<?php

namespace App\Model\Entity;

use \App\Core\Database;

class User
{
    public $id;
    public $nome;
    public $user;
    public $password;

    public static function getUserByUser($user)
    {
        return (new Database("usuarios"))->select("usuario = '{$user}'")->fetchObject(self::class);
    }
}