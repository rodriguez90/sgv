<?php

use yii\db\Migration;

/**
 * Class m190310_181731_alter_table_voto_junta
 */
class m190310_181731_alter_table_voto_junta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->dropColumn('voto', 'null_vote');
//        $this->dropColumn('voto', 'blank_vote');

        $this->addColumn('junta', 'null_vote', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('junta', 'blank_vote', $this->integer()->notNull()->defaultValue(0));
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
        echo "m190310_181731_alter_table_voto_junta cannot be reverted.\n";

        return false;
    }
    */
}
