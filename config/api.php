<?php

$config = [
    'id' => 'api',
    'timeZone'  => 'Europe/Moscow',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@RateInformer/Api' => ROOT_DIR . '/api',
     ],
    'basePath' => ROOT_DIR . '/api',
    'bootstrap' => ['log'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => require __DIR__ . '/db.php',
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/api.log',
                ],
            ],
        ],
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules' => [
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'currency',
                    'patterns'   => [
                        'GET,HEAD' => 'list',
                    ],
                ],
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => 'currency',
                    'patterns'   => [
                        'GET,HEAD {id}' => 'view',
                        '{id}'          => 'options',
                        ''              => 'options'
                    ],
                    'pluralize' => false,
                    'tokens' => ['{id}' => '<id:[a-zA-Z]{3}>']
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'RateInformer\Api\Models\User',
            'enableSession' => false
        ],
    ],
    'controllerNamespace' => 'RateInformer\Api\Controllers',
    'runtimePath' => ROOT_DIR . '/runtime',
    'vendorPath' => ROOT_DIR . '/vendor',
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
