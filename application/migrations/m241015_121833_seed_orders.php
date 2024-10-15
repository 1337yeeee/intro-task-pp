<?php

use yii\db\Migration;

/**
 * Class m241015_121833_seed_orders
 */
class m241015_121833_seed_orders extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $filePath = __DIR__ . '/sql/orders';

        $batchSize = 1000; // Вставляем по 1000 записей за раз

        // Используем транзакцию для повышения производительности
        $this->db->createCommand('SET foreign_key_checks = 1;')->execute(); // Отключаем проверки внешних ключей
        $transaction = $this->db->beginTransaction();
        if(is_null($transaction)) throw new \yii\db\Exception('Transaction has not been started.');

        $i = 0;
        while(is_dir($dirPath = $filePath."_{$i}.sql")) {
            $i++;
            $sql = file_get_contents($dirPath);
            $this->execute($sql);
        }

        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241015_121833_seed_orders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241015_121833_seed_orders cannot be reverted.\n";

        return false;
    }
    */
}
