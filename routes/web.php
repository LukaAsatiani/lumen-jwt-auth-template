<?php

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');
});

$router->addRoute(['GET','POST', 'PUT', 'PATCH', 'DELETE','OPTIONS'], '/{any:.*}', function(){
    return response()->json(["error" => "Route not found."], 404);
});