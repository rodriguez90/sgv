<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
//    'bootstrap' => ['log', 'history'],
    'bootstrap' => ['log',],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'es',
    'name'=>'SGV',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dsdsdsadsadasd',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'Da\User\Model\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
//            'class' => 'yii\rbac\DbManager',
            'class' => 'Da\User\Component\AuthDbManagerComponent',
//            'class' => 'justcoded\yii2\rbac\components\DbManager',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i',
            'timeFormat' => 'php:H:i:s',
            'thousandSeparator'=>'.',
            'decimalSeparator'=>',',
            'currencyCode'=>'USD'
        ],
        'as AccessBehavior' => [
            'class' => '\app\components\AccessBehavior'
        ],
//            'assetManager' => [
//                'bundles' => [
//                    'dosamigos\google\maps\MapAsset' => [
//                        'options' => [
//                            'key' => 'this_is_my_key',
////                            235137657038-qo4i4essgutmqe7ngk073s2hm67che6b.apps.googleusercontent.com
////                            ID de cliente:
////235137657038-qo4i4essgutmqe7ngk073s2hm67che6b.apps.googleusercontent.com
////   Secreto de cliente:
////RDfTwb5xRT6Y6csECBn62Hq2
//                            'language' => 'id',
//                            'version' => '3.1.18'
//                        ]
//                    ]
//                ]
//            ],
//        ],
    ],
    'modules' => [
        'gridView' => [
            'class' => '\kartik\grid\Module'
        ],
        'user' => [
            'class' => Da\User\Module::class,
            'administrators'=>['root'],
            'administratorPermissionName'=>'admin',
            'enableRegistration'=>false,
            'enableEmailConfirmation'=>false,
            'allowUnconfirmedEmailLogin'=>true,
            'allowAccountDelete'=>false,

            // ...other configs from here: [Configuration Options](installation/configuration-options.md), e.g.
            // 'generatePasswords' => true,
            // 'switchIdentitySessionKey' => 'myown_usuario_admin_user_key',
        ],
//        'rbac' => [
//            'class' => 'justcoded\yii2\rbac\Module'
//        ],
//        'history' => [
//            'class' => 'bupy7\activerecord\history\Module',
//            'tableName' => '{{%history}}', // table name of saving changes of model
//            'storage' => 'bupy7\activerecord\history\storages\Database', // class name of storage for saving history of active record model
//            'db' => 'db', // database connection component config or name
//            'user' => 'user', // authentication component config or name
//        ],
//        'gridview' =>  [
//            'class' => '\kartik\grid\Module',
//            // enter optional module parameters below - only if you need to
//            // use your own export download action or custom translation
//            // message source
//            // 'downloadAction' => 'gridview/export/download',
//            'i18n' => [
//                'class' => 'yii\i18n\PhpMessageSource',
//                'basePath' => '@kvgrid/messages',
//                'forceTranslation' => true
//            ]
//        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*'],
        'generators' => [ //here
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],
    ];
}

return $config;
