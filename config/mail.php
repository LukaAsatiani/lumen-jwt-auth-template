<?php
return [
    
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 465),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'from@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'from'),
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
    'username' => env('MAIL_USERNAME', 'chessoutapp@gmail.com'),
    'password' => env('MAIL_PASSWORD', '2.ERalgo'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
    
    'log_channel' => env('MAIL_LOG_CHANNEL'),
];
