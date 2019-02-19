<?php

use yii\db\Migration;

/**
 * Handles the creation of table `voto`.
 */
class m190218_232914_create_voto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('voto', [
            'id' => $this->primaryKey(),
            'recinto_eleccion_id' => $this->integer()->notNull(),
            'postulacion_id' => $this->integer()->notNull(),
            'v_jr_man' => $this->integer()->notNull(), // v - voto
            'v_jr_woman' => $this->integer()->notNull(),
            'vn_jr_man' => $this->integer()->notNull(), // vn - voto nulo
            'vn_jr_woman' => $this->integer()->notNull(),
            'vb_jr_man' => $this->integer()->notNull(), // vb - voto en blanco
            'vb_jr_woman' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_voto_recinto_eleccion',
            'voto',
            'recinto_eleccion_id',
            'recinto_eleccion',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_voto_postulacion',
            'voto',
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
        $this->dropTable('voto');
    }
}
