<?php

use yii\db\Migration;

/**
 * Class m190307_140234_create_table_juntas
 */
class m190307_140234_create_table_juntas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('junta', [
            'id' => $this->primaryKey(),
            'recinto_eleccion_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_junta_recinto_eleccion',
            'junta',
            'recinto_eleccion_id',
            'recinto_eleccion',
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
        $this->dropTable('junta');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190307_140234_create_table_juntas cannot be reverted.\n";

        return false;
    }
    */
}
