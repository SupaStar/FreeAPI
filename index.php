<?php
require 'start.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Routing\Pipeline;

$middlewares = [
    \App\Middleware\StartSession::class,
];
$routeMiddleware = [
    'jwt' =>\App\Middleware\JwtMiddleware::class,
];

$container = new Container;

$request = Request::capture();

$container->instance('Illuminate\Http\Request', $request);

$events = new Dispatcher($container);

$router = new Router($events, $container);

foreach ($routeMiddleware as $key => $middleware) {
    $router->aliasMiddleware($key, $middleware);
}

require_once 'routes/api.php';

$redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));

$response = (new Pipeline($container))
    ->send($request)
    ->through($middlewares)
    ->then(function ($request) use ($router) {
        return $router->dispatch($request);
    });

$response->send();

?>