<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m241015_120230_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->notNull(),
            'first_name' => $this->string(300)->notNull(),
            'last_name' => $this->string(300)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
