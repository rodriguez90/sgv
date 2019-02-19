<?php

use yii\db\Migration;

/**
 * Handles the creation of table `persona`.
 */
class m190218_230506_create_persona_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('persona', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'phone_number' => $this->string()->notNull(),
            'gender' => $this->char(), // M, F, O (Other)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('persona');
    }
}
