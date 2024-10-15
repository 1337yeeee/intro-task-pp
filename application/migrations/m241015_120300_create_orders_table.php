<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m241015_120300_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'link' => $this->string(300)->notNull(),
            'quantity' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->comment('0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail'),
            'created_at' => $this->integer()->notNull(),
            'mode' => $this->tinyInteger(1)->notNull()->comment('0 - Manual, 1 - Auto'),
        ]);

        // Установим автоинкремент
        $this->execute('ALTER TABLE {{%orders}} AUTO_INCREMENT = 100001;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
