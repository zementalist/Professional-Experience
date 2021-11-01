<?php

namespace App;


class Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    public $middleware = [
        'auth' => \App\Middleware\AuthMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    public $middlewareGroups = [
        'auth' => \App\Middleware\AuthMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    public $routeMiddleware = [
        'auth' => \App\Middleware\AuthMiddleware::class,
    ];
}
