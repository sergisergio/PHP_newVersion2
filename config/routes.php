<?php

return [
    'home' => [
        'path' => '/',
        'methods' => ['GET', 'POST'],
        'action' => App\Controller\HomeController::class
    ],
    'error4O4' => [
        'path' => '/error404',
        'methods' => ['GET','POST'],
        'action' => App\Controller\Error404Controller::class
    ],
    'blog1' => [
        'path' => '/blog/{v}/{p}',
        'methods' => ['GET','POST'],
        'action' => App\Controller\BlogController::class,
        'params' => ['v' => '\d+', 'p' => '\d+']
    ],
    'post' => [
        'path' => '/blog/article/{id}',
        'methods' => ['GET','POST'],
        'action' => App\Controller\PostController::class,
        'params' => ['id' => '\d+']
    ],
    'login' => [
        'path' => '/login',
        'methods' => ['GET','POST'],
        'action' => App\Controller\LoginController::class
    ]

];
