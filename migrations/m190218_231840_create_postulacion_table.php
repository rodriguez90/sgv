<?php

use yii\db\Migration;

/**
 * Handles the creation of table `postulacion`.
 */
class m190218_231840_create_postulacion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('postulacion', [
            'id' => $this->primaryKey(),
            'partido_id' => $this->integer()->notNull(),
            'candidate_id' => $this->integer()->notNull(),
            'eleccion_id' => $this->integer()->notNull(),
            'role' => $this->integer()->notNull(), // consejal, alcaldia, prefectura
        ]);

        $this->addForeignKey(
            'fk_postulacion_partido',
            'postulacion',
            'partido_id',
            'partido',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_postulacion_candidate',
            'postulacion',
            'candidate_id',
            'profile',
            'user_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_postulacion_eleccion',
            'postulacion',
            'eleccion_id',
            'eleccion',
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
        $this->dropTable('postulacion');
    }
}
