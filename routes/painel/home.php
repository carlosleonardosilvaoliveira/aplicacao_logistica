<?php

use \App\Http\Response;
use \App\Controller\Panel;

$obRouter->get('/',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\Home::getHome($request));
    }
]);