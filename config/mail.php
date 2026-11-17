<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array", "failover"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],

        // Sends the customer confirmation emails as the support mailbox. Hostinger only lets an
        // SMTP login send "From" its own address, so support@ needs its own login here.
        // Host/port/encryption default to the main SMTP settings.
        'support' => [
            'transport' => 'smtp',
            'host' => env('MAIL_SUPPORT_HOST', env('MAIL_HOST', 'smtp.mailgun.org')),
            'port' => env('MAIL_SUPPORT_PORT', env('MAIL_PORT', 587)),
            'encryption' => env('MAIL_SUPPORT_ENCRYPTION', env('MAIL_ENCRYPTION', 'tls')),
            'username' => env('MAIL_SUPPORT_USERNAME', env('MAIL_SUPPORT_ADDRESS')),
            'password' => env('MAIL_SUPPORT_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -t -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    // Form submissions (the table-style admin emails) are delivered to this inbox.
    // Keep this key named 'admin', never 'to': Laravel treats config('mail.to') as a global
    // "always send to" address and would redirect every email, including the customer's
    // confirmation, to this inbox.
    'admin' => [
        'address' => env('MAIL_TO_ADDRESS', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
        'name' => env('MAIL_TO_NAME', env('MAIL_FROM_NAME', 'Go Custom Boxes')),
    ],

    // The "thank you" confirmation that goes only to the customer is sent from this address.
    // 'mailer' picks the mailer that sends it: the 'support' SMTP login above once
    // MAIL_SUPPORT_PASSWORD is set, otherwise the default mailer.
    'support' => [
        'address' => env('MAIL_SUPPORT_ADDRESS', 'support@gocustomboxes.com'),
        'name' => env('MAIL_SUPPORT_NAME', 'Go Custom Boxes Support'),
        'mailer' => env('MAIL_SUPPORT_MAILER', env('MAIL_SUPPORT_PASSWORD') ? 'support' : null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
