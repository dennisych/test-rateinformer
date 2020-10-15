<?php

require dirname(__DIR__) . '/config/definitions.php';
require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/vendor/yiisoft/yii2/Yii.php';

$config = require ROOT_DIR . '/config/cli.php';

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);
