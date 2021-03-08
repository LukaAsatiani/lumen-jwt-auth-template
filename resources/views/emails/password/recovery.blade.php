@extends('emails.layout')

@component('mail::message')

# Hello, {!!isset($username) ? $username : '<i style="color:crimson"><--Null--></i>'!!}.

<br>
Click the button below to recovery your account password.
<br>
<br>

@component('mail::button', ['url' => isset($uri) ? env('APP_URL').$uri : '#', 'color'=>'green'])
Recovery password
@endcomponent

{{ config('app.name') }}
@endcomponent