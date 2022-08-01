<?php

namespace App\Session;

class Login
{
    private static function init()
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($obUser)
    {
        self::init();

        $_SESSION['usuario'] = [
            'id' => $obUser->id,
            'nome' => $obUser->nome,
            'usuario' => $obUser->user
        ];

        return true;
    }

    public static function isLogged()
    {
        self::init();

        return isset($_SESSION['usuario']['id']);
    }

    public static function logout()
    {
        self::init();

        unset($_SESSION['usuario']);

        return true;
    }
}