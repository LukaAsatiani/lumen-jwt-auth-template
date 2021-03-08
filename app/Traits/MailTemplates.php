<?php

namespace App\Traits;

trait MailTemplates {
    public $templates = [
        'REGISTRATION_CONFORMATION' => [
            'subject' => 'Please Confirm Your E-mail Address!',
            'markdown' => 'emails.registration.confirmation'
        ],
        'PASSWORD_RECOVERY' => [
            'subject' => 'Password Recovery',
            'markdown' => 'emails.password.recovery'
        ]
    ];
}