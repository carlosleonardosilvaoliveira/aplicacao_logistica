<?php

namespace App\Controller\Exceptions;

use App\Utils\View;

class Alert
{
    public static function getSuccess($message)
    {
        return View::render('exceptions/alert/status',[
            'tipo' => 'success',
            'mensagem' => $message
        ]);
    }

    public static function getError($message)
    {
        return View::render('exceptions/alert/status',[
            'tipo' => 'danger',
            'mensagem' => $message
        ]);
    }
}