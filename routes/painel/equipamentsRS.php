<?php

use App\Http\Response;
use App\Controller\Panel;

$obRouter->get('/equipamentsRS',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsRS::getEquipaments($request));
    }
]);

$obRouter->get('/equipamentsRS/importChamados',[
   'middlewares' => [
        'required-login'
   ],
    function($request) {
    return new Response(200, Panel\EquipamentsRS::getImportChamados($request));
    }
]);

$obRouter->post('/equipamentsRS',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsRS::setImportChamados($request));
    }
]);

$obRouter->get('/equipamentsRS/import',[
    'middlewares' => [
      'required-login'
    ],
    function($request) {
        return new Response(200,Panel\EquipamentsRS::getImport($request));
    }
]);

$obRouter->post('/equipamentsRS',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200,Panel\EquipamentsRS::setImport($request));
    }
]);

$obRouter->post('equipamentsRS',[
    'middlewares' => [
        'required-login'
    ],
    function($request){
        return new Response(200,Panel\EquipamentsRS::setEditEmail($request));
    }
]);
