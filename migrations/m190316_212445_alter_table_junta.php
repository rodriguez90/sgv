<?php

use yii\db\Migration;

/**
 * Class m190316_212445_alter_table_junta
 */
class m190316_212445_alter_table_junta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'junta',
            'count_elector',
            $this->integer()->defaultValue(0));

        $this->addColumn(
            'junta',
            'count_vote',
            $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190316_212445_alter_table_junta cannot be reverted.\n";

        return false;
    }
    */
}
