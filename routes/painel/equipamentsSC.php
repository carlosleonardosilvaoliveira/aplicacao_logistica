<?php

use App\Http\Response;
use App\Controller\Panel;

$obRouter->get('/equipamentsSC',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsSC::getEquipaments($request));
    }
]);

$obRouter->get('/equipamentsSC/importChamados',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsSC::getImportChamados($request));
    }
]);

$obRouter->post('/equipamentsSC',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\EquipamentsSC::setImportChamados($request));
    }
]);

$obRouter->get('/equipamentsSC/import',[
    'middlewares' => [
        'required-login'
    ],
    function($request, $n_terminal) {
        return new Response(200,Panel\EquipamentsSC::getImport($request, $n_terminal));
    }
]);

$obRouter->post('/equipamentsSC',[
    'middlewares' => [
        'required-login'
    ],
    function($request, $n_terminal) {
        return new Response(200,Panel\EquipamentsSC::setImport($request, $n_terminal));
    }
]);

$obRouter->post('equipamentsSC',[
   'middlewares' => [
       'required-login'
   ],
    function($request){
        return new Response(200,Panel\EquipamentsSC::setEditEmail($request));
    }
]);

$obRouter->post('equipamentsSC', [
    'middlewares' => [
        'required-login'
    ],
    function($request){
        return new Response(200, Panel\EquipamentsSC::setExport($request));
    }
]);
