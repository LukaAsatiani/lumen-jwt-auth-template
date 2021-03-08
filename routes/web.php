<?php

use App\Http\Controllers\MailController;

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout');
    
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['middleware' => 'roles:admin'], function () use ($router) {
            $router->get('users', 'UserController@allUsers'); 
        });
            
        $router->get('profile', 'UserController@profile');
        $router->get('users/{id}', 'UserController@singleUser');
        $router->patch('profile', 'UserController@changeProfileData');
    });
    $router->get('sendMail', 'UserController@sendMail');
    
    $router->group(['prefix' => 'email'], function () use ($router) {
        $router->get('confirmation/{c_uri}', 'EmailConfirmationController@confirm');
        $router->get('confirmation', 'EmailConfirmationController@send');
    });
    $router->group(['prefix' => 'password'], function () use ($router) {
        $router->get('recovery/{c_uri}', 'PasswordRecoveryController@confirm');
        $router->post('recovery', 'PasswordRecoveryController@send');
    });
});

$router->group(['prefix' => 'mail'], function () use ($router) {
    $router->get('', 'MailTemplatesController@list');
    $router->get('{template}', 'MailTemplatesController@show');
});

$router->addRoute(['GET','POST', 'PUT', 'PATCH', 'DELETE','OPTIONS'], '/{any:.*}', function(){
    return response()->json(["error" => "Route not found."], 404);
});