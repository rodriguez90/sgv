<?php

use yii\db\Migration;

/**
 * Class m190321_183027_create_table_acta
 */
class m190321_183027_create_table_acta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('acta', [
            'id' => $this->primaryKey(),
            'junta_id'=>$this->integer()->notNull(),
            'count_elector'=>$this->integer()->notNull(),
            'count_vote'=>$this->integer()->notNull(),
            'null_vote'=>$this->integer()->notNull(),
            'blank_vote'=>$this->integer()->notNull(),
            'type' => $this->integer()->notNull(), // digniadad o rol
        ]);

        $this->addForeignKey(
            'fk_acta_junta',
            'acta',
            'junta_id',
            'junta',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->dropForeignKey('fk_vote_junta', 'voto');

        $this->renameColumn('voto', 'junta_id', 'acta_id');

        $this->addForeignKey(
            'fk_voto_acta',
            'voto',
            'acta_id',
            'acta',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->dropColumn('junta', 'count_elector');
        $this->dropColumn('junta', 'count_vote');
        $this->dropColumn('junta', 'null_vote');
        $this->dropColumn('junta', 'blank_vote');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('acta');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190321_183027_create_table_acta cannot be reverted.\n";

        return false;
    }
    */
}
