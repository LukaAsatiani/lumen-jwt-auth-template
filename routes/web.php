<?php

use App\Http\Controllers\EmailConfirmationController;
use App\Mail\RegistrationConfirmation;
use App\Http\Controllers\MailController;

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');
    $router->get('sendMail', 'Usercontroller@sendMail');
    $router->get('email/confirmation/{c_uri}', 'EmailConfirmationController@confirm');
});

$router->group(['prefix' => 'email'], function () use ($router) {
    $router->get('show', function(){
        return MailController::showEmailTemplate('REGISTRATION_CONFORMATION', ['email'=>'limitpoint73@gmail.com', 'name'=>'drinkoron', 'url'=>'https://google.com']);
    });
});

$router->addRoute(['GET','POST', 'PUT', 'PATCH', 'DELETE','OPTIONS'], '/{any:.*}', function(){
    return response()->json(["error" => "Route not found."], 404);
});