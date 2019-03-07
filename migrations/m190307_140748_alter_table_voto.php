<?php

use yii\db\Migration;

/**
 * Class m190307_140748_alter_table_voto
 */
class m190307_140748_alter_table_voto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_voto_recinto_eleccion', 'voto');
        $this->dropColumn('voto', 'recinto_eleccion_id');
        $this->dropColumn('voto', 'v_jr_man');
        $this->dropColumn('voto', 'v_jr_woman');
        $this->dropColumn('voto', 'vn_jr_man');
        $this->dropColumn('voto', 'vn_jr_woman');
        $this->dropColumn('voto', 'vb_jr_man');
        $this->dropColumn('voto', 'vb_jr_woman');

        $this->addColumn('voto', 'junta_id',$this->integer()->notNull());
        $this->addColumn('voto', 'vote',$this->integer()->notNull());
        $this->addColumn('voto', 'null_vote',$this->integer()->notNull());
        $this->addColumn('voto', 'blank_vote',$this->integer()->notNull());
        $this->addColumn('voto', 'user_id',$this->integer()->notNull());

        $this->addForeignKey(
            'fk_vote_junta',
            'voto',
            'junta_id',
            'junta',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk_vote_user',
            'voto',
            'user_id',
            'user',
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

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190307_140748_alter_table_voto cannot be reverted.\n";

        return false;
    }
    */
}
