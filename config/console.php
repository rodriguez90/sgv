<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
//        'user' => [
////            'identityClass' => 'app\models\User',
//            'identityClass' => 'Da\User\Model\User',
//            'enableAutoLogin' => true,
//        ],
        'db' => $db,
        'authManager' => [
            'class' => 'Da\User\Component\AuthDbManagerComponent',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => Da\User\Module::class,
            'administrators'=>['root']
            // ...other configs from here: [Configuration Options](installation/configuration-options.md), e.g.
            // 'generatePasswords' => true,
            // 'switchIdentitySessionKey' => 'myown_usuario_admin_user_key',
        ],
//        'history' => [
//            'class' => 'bupy7\activerecord\history\Module',
//            'tableName' => '{{%history}}', // table name of saving changes of model
//            'storage' => 'bupy7\activerecord\history\storages\Database', // class name of storage for saving history of active record model
//            'db' => 'db', // database connection component config or name
//            'user' => 'user', // authentication component config or name
//        ],
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
