<?php

namespace RateInformer\Cli\Controllers;

use RateInformer\Cli\Tasks\BuildSwagger;
use RateInformer\Cli\Tasks\UpdateCurrencyRates;

/**
 * Provides various management tasks.
 */
class TaskController extends \yii\console\Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
           'build-swagger'         => BuildSwagger::class,
           'update-currency-rates' => UpdateCurrencyRates::class,
        ];
    }
}
