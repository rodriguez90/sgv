<?php

use yii\db\Migration;

/**
 * Class m190321_072302_create_table_postulacion_canton
 */
class m190321_072302_create_table_postulacion_canton extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('postulacion_canton', [
            'id' => $this->primaryKey(),
            'postulacion_id' => $this->integer()->notNull(),
            'canton_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_postulacion_canton_canton',
            'postulacion_canton',
            'canton_id',
            'canton',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_postulacion_canton_postulacion',
            'postulacion_canton',
            'postulacion_id',
            'postulacion',
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
        $this->dropTable('postulacion_canton');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190321_072302_create_table_postulacion_canton cannot be reverted.\n";

        return false;
    }
    */
}
