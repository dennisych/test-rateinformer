<?php

namespace RateInformer\Cli\Tasks;

use RateInformer\Api\Models\Currency;
use RateInformer\Cli\DataProviders\ICurrencyRatesProvider;

class UpdateCurrencyRates extends \yii\base\Action
{
    /**
     * Task обновления курсов валют.
     */
    public function run(ICurrencyRatesProvider $ratesProvider)
    {
        try {
            $data = $ratesProvider->getRates();

            $command = \Yii::$app->db->createCommand()->batchInsert(
                Currency::tableName(),
                array_keys($data[0]),
                $data
            );
    
            $sql = $command->getRawSql();
            $sql .= ' ON DUPLICATE KEY UPDATE `rate` = VALUES(`rate`)';
            $command->setRawSql($sql)->execute();
    
            echo 'Обновлено курсов валют выполнено успешно', PHP_EOL;
        } catch (\Throwable $th) {
            echo 'Ошибка обновления данных.', PHP_EOL;
            echo 'Подробности: ', $th->getMessage();
            exit($th->getCode());
        }
    }
}
