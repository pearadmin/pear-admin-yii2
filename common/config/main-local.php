<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=103.108.193.218;dbname=hongkong',
            'username' => 'hongkong',
            'password' => '6WbfJcYxsHGK3dKi',
            'charset' => 'utf8',
            'tablePrefix'=>'yp_'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],

    ],
];
