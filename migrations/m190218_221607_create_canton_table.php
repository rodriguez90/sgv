<?php

use yii\db\Migration;

/**
 * Handles the creation of table `canton`.
 */
class m190218_221607_create_canton_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('canton', [
            'id' => $this->primaryKey(),
            'province_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => $this->smallInteger()->notNull() // Rural, Norte, Sur
        ]);

        $this->addForeignKey(
            'fk_canton_province',
            'canton',
          'province_id',
            'province',
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
        $this->dropTable('canton');
    }
}
