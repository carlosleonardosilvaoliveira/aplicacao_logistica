<?php

require __DIR__.'/../vendor/autoload.php';

use App\Core\Database;
use App\Core\Environment;
use App\Http\Middleware\Queue as MiddlewareQueue;
use App\Utils\View;

Environment::load(__DIR__.'/../');

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS')
);

define('URL', getenv('URL'));

View::init([
    'URL' => URL
]);

MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class,
    'required-logout' => \App\Http\Middleware\RequireLogout::class,
    'required-login' => \App\Http\Middleware\RequireLogin::class
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);