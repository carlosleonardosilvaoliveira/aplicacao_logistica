<?php

use App\Http\Response;
use App\Controller\Panel;

$obRouter->get('/equipamentsPR',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsPR::getEquipaments($request));
    }
]);

$obRouter->get('/equipamentsPR/importChamados',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsPR::getImportChamados($request));
    }
]);

$obRouter->post('/equipamentsPR',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsPR::setImportChamados($request));
    }
]);

$obRouter->get('/equipamentsPR/import',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200,Panel\EquipamentsPR::getImport($request));
    }
]);

$obRouter->post('/equipamentsPR',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200,Panel\EquipamentsPR::setImport($request));
    }
]);

$obRouter->post('equipamentsPR',[
    'middlewares' => [
        'required-login'
    ],
    function($request){
        return new Response(200,Panel\EquipamentsPR::setEditEmail($request));
    }
]);