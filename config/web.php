<?php

$config = parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web.ini');

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1PcJIadjhGn_BrlrEpkY-cQDVQgQJ3-A',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => $config['mailer_username'],
                'password' => $config['mailer_password'],
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'reservation/<slug>' => 'site/reservation',
                'gallery/<slug>' => 'site/gallery',
                'check-room-availability' => 'site/check-room-availability',
                'home' => 'site/index',
                'explore' => 'site/explore',
                'services' => 'site/services',
                'menus' => 'site/menus',
                'confirm-reservation/<id:\d+>' => 'site/confirm-reservation',
                'agreement/<package_id:\d+>/<slug>' => 'site/agreement',
                'administrator/transaction/check-in/<reservation_id:\d+>' => 'administrator/transaction/check-in',
                'administrator/order/create/<transaction_id:\d+>' => 'administrator/order/create',
                'administrator/service/create/<transaction_id:\d+>' => 'administrator/service/create',
                /*'package' => 'package/index',
                'package/index' => 'package/index',
                'package/create' => 'package/create',
                'package/view/<id:\d+>' => 'package/view',
                'package/update/<id:\d+>' => 'package/update',
                'package/delete/<id:\d+>' => 'package/delete',
                'package/<slug>' => 'package/slug',*/
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'timeZone' => 'Asia/Manila',
            'currencyCode' => 'PHP',
        ],
        'myPaypalPayment' => [
            'class' => 'app\components\MyPaypalPayment',
            'client_id' => $config['paypal_client_id'],
            'client_secret' => $config['paypal_client_secret'],
            'currency' => 'USD',
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'markdown' => [
            'class' => 'kartik\markdown\Module',
        ],
        'administrator' => [
            'class' => 'app\modules\administrator\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /*$config['bootstrap'][] = 'debug';*/
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
