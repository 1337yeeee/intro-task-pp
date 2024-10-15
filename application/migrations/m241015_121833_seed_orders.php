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

        // Используем транзакцию для повышения производительности
        $this->db->createCommand('SET foreign_key_checks = 1;')->execute(); // Отключаем проверки внешних ключей
        $transaction = $this->db->beginTransaction();
        if(is_null($transaction)) throw new \yii\db\Exception('Transaction has not been started.');

        $i = 1;
        while(is_file($dirPath = $filePath."_{$i}.sql")) {
            echo "\n\n\n!_+!_!+_!+_!+_!+!_+!_!+_+!_+!_+!_+!\n".$i . "\n\n\n\n";
            $i++;
            $sql = file_get_contents($dirPath);
            $this->execute($sql);
            echo $i . "\n";
        }

        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('orders');
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
