<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recinto_electoral`.
 */
class m190218_225139_create_recinto_electoral_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('recinto_electoral', [
            'id' => $this->primaryKey(),
            'zona_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_recinto_electoral_zona',
            'recinto_electoral',
            'zona_id',
            'zona',
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
        $this->dropTable('recinto_electoral');
    }
}
