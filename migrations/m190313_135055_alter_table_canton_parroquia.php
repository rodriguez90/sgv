<?php

use yii\db\Migration;

/**
 * Class m190313_135055_alter_table_canton_parroquia
 */
class m190313_135055_alter_table_canton_parroquia extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('canton', 'type');
        $this->addColumn('parroquia', 'type', $this->integer()->notNull()->defaultValue(1));
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
        echo "m190313_135055_alter_table_canton_parroquia cannot be reverted.\n";

        return false;
    }
    */
}
