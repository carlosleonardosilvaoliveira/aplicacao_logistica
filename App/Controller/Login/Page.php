<?php

namespace App\Controller\Login;

use App\Utils\View;

class Page
{
    public static function getPage($title, $content)
    {
        return View::render('login/page',[
           'title'  => $title,
           'content'=> $content
        ]);
    }
}