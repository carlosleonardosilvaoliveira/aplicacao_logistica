<?php

namespace App\Controller\Login;

use App\Controller\Exceptions\Alert;
use App\Model\Entity\User;
use App\Session\Login as SessionLogin;
use App\Utils\View;

class Login extends Page
{
    public static function getLogin($request, $errorMessage = null)
    {
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        $content = View::render('login/login',[
            'status' => $status
        ]);

        return parent::getPage('Login', $content);
    }

    public static function setLogin($request)
    {
        $postVars = $request->getPostVars();
        $user = $postVars['username'] ?? '';
        $password = $postVars['password'] ?? '';

        $obUser = User::getUserByUser($user);


        if(!$obUser instanceof User) {
            return self::getLogin($request, 'Usuário ou senha inválidos.');
        }

        if(!password_verify($password,$obUser->senha)) {
            return self::getLogin($request, 'Usuário ou senha inválidos.');
        }

        SessionLogin::login($obUser);

        $request->getRouter()->redirect('/equipamentsRS');
    }

    public static function setLogout($request)
    {
        SessionLogin::logout();

        $request->getRouter()->redirect('/');
    }
}