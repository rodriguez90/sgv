<?php

use yii\db\Migration;

/**
 * Handles the creation of table `eleccion`.
 */
class m190218_230154_create_eleccion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('eleccion', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'delivery_date' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('eleccion');
    }
}
