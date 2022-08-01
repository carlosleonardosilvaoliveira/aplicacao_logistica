<?php

namespace App\Controller\Panel;

use App\Utils\View;

class Home extends Page
{
    public static function getHome($request)
    {
        $content = View::render('painel/modules/home/index',[]);

        return parent::getPanel('Home Painel', $content, 'home');
    }
}