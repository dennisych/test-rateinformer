<?php

use RateInformer\Cli\DataProviders\ICurrencyRatesProvider;
use RateInformer\Cli\DataProviders\CrbXmlRatesDataProvider;

$config = [
    'id'        => 'cli',
    'timeZone'  => 'Europe/Moscow',
    'bootstrap' => ['log'],
    'basePath'  => ROOT_DIR . '/cli',
    'aliases'   => [
        '@RateInformer/Cli' => ROOT_DIR . '/cli',
    ],
    'container' => [
        'singletons' => [
            ICurrencyRatesProvider::class => CrbXmlRatesDataProvider::class,
        ],
    ],
    'controllerNamespace' => 'RateInformer\Cli\Controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'RateInformer\Cli\Fixtures',
        ],
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'log' => [
            'traceLevel' => 3,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/cli.log',
                ],
            ],
        ],
    ],
    'runtimePath' => ROOT_DIR . '/runtime',
    'vendorPath' => ROOT_DIR . '/vendor',
];

if (YII_DEBUG) {
    $config['components']['log']['targets'][0]['levels'][] = 'info';
}

return $config;
