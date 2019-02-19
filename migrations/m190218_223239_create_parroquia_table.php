<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parroquia`.
 */
class m190218_223239_create_parroquia_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parroquia', [
            'id' => $this->primaryKey(),
            'canton_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_parroquia_canton',
            'parroquia',
            'canton_id',
            'canton',
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
        $this->dropTable('parroquia');
    }
}
