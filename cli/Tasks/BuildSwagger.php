<?php

namespace RateInformer\Cli\Tasks;

class BuildSwagger extends \yii\base\Action
{
    /**
     * Task создания файла документации API (swagger.json).
     */
    public function run()
    {
        $scanDir = dirname(__DIR__, 2) . '/api';
        $openapi = \OpenApi\scan($scanDir);
        $outputDir = dirname($scanDir) . '/wwwroot/doc';
        if (!file_exists($outputDir)) {
            mkdir($outputDir);
        }
        file_put_contents($outputDir . '/swagger.json', $openapi->toJson());
        echo 'Documentation file created successfuly', PHP_EOL;
    }
}
