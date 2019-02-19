<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recinto_eleccion`.
 */
class m190218_230647_create_recinto_eleccion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('recinto_eleccion', [
            'id' => $this->primaryKey(),
            'recinto_id' => $this->integer()->notNull(),
            'coordinator_jr_man' => $this->integer()->notNull(),
            'coordinator_jr_woman' => $this->integer()->notNull(),
            'eleccion_id' => $this->integer()->notNull(),
            'jr_woman' => $this->integer(),
            'jr_man' => $this->integer(),
            'count_elector' => $this->integer(),

        ]);

        $this->addForeignKey(
            'fk_recinto_eleccion_recinto',
            'recinto_eleccion',
            'recinto_id',
            'recinto_electoral',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_recinto_eleccion_coordinador_m',
            'recinto_eleccion',
            'coordinator_jr_man',
            'persona',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_recinto_eleccion_coordinador_w',
            'recinto_eleccion',
            'coordinator_jr_woman',
            'persona',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_recinto_eleccion_eleccion',
            'recinto_eleccion',
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
        $this->dropTable('recinto_eleccion');
    }
}
