<?php

namespace RateInformer\Api\Models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property string $id ISO 4217 alfa-3 код валюты
 * @property string $name Наименование вылюты
 * @property float|null $rate Курс валюты по отношению к российскому рублю
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['rate'], 'number'],
            [['id'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'rate' => 'Rate',
        ];
    }
}
