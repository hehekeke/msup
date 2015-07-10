<?php
/**
 * Application configuration shared by all applications and test types
 */
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=msup',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix'=>'msup_',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
