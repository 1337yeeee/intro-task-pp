<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services}}`.
 */
class m241015_120157_create_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('services', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(300)->notNull(),
        ]);

        // Установим автоинкремент
        $this->execute('ALTER TABLE {{%services}} AUTO_INCREMENT = 18;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('services');
    }
}
