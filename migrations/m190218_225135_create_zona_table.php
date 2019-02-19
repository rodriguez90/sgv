<?php

use yii\db\Migration;

/**
 * Handles the creation of table `zona`.
 */
class m190218_225135_create_zona_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('zona', [
            'id' => $this->primaryKey(),
            'parroquia_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_zona_parroquia',
            'zona',
            'parroquia_id',
            'parroquia',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('zona');
    }
}
