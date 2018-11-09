<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('categories', CategoryController::class);
    $router->resource('courses', CourseController::class);
    $router->resource('users', UserController::class);
    $router->resource('parser', ParserController::class, ['except'=>['edit','show']]);
    $router->resource('notifies', NotifyController::class, ['except'=>['edit','show','create']]);


});


