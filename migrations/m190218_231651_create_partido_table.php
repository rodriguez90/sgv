<?php

use yii\db\Migration;

/**
 * Handles the creation of table `partido`.
 */
class m190218_231651_create_partido_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('partido', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'list' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('partido');
    }
}
