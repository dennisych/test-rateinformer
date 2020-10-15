<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m201014_053903_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->char(3),
            'name' => $this->string(255)->notNull(),
            'rate' => $this->decimal(11, 8)->notNull(),
        ]);
        $this->addPrimaryKey('id', '{{%currency}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}
