<?php

use yii\db\Migration;

/**
 * Class m241024_081253_add_foreignkey_on_orders_users
 */
class m241024_081253_add_foreignkey_on_orders_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx_orders_user_id',
            'orders',
            'user_id'
        );

        $this->addForeignKey(
            'fk_orders_user_id',
            'orders',
            'user_id',
            'users',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_orders_user_id',
            'orders'
        );

        $this->dropIndex(
            'idx_orders_user_id',
            'orders'
        );
    }
}
