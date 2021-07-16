<?php

use Controllers\UsuarioController;
use Illuminate\Routing\Router;

/** @var $router Router */

$router->post('nuevoUsuario', [UsuarioController::class, 'crearUsuario']);

$router->post('login', [UsuarioController::class, 'login']);

$router->any('{any}', function () {
    return '404';
})->where('any', '(.*)');