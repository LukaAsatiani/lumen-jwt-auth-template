<?php

return [
    'created' => 'Запись добавлена.',
    'updated' => 'Запись обнавлена.',
    'message' => [
        'user' => [
            'created' => 'Аккаунт был создан успешно.',
            'updated' => 'Аккаунт был обновлён успешно.',
            'logout' => 'Вы вышли из аккаунта.',
            'login' => 'Вы успешно вошли в аккаунт.'
        ],
        'confirmation' => [
            'success' => 'Account confirmed.',
            'sent' => 'Confirmation letter was sent to :email'
        ],
        'recovery' => [
            'sent' => 'Password recovery letter was send to :email'
        ]
    ],
    'error' => [
        'reg' => 'Ошибка при регистрации!',
        'login' => 'Неправильный адрес электронной почты или пароль!',
        'unauthorized' => 'Вы не авторизованы!',
        'language' => 'Данный язык не поддерживается!',
        'database' => 'Ошибка при подключении к базе данных!',
        'user' => [
            'find' => 'User not found!',
            'update' => 'User data update failed!',
            'permission' => 'You don’t have permission to access!',
            'confirmed' => 'Подтвердите адрес вашей электронной почты!'
        ],
        'confirmation' => [
            'url' => 'Invalid email confirmation url!'
        ],
        'email' => [
            'find' => 'Email does not found!',
            'confirmed' => 'Email already confirmed!'
        ]
    ]
];