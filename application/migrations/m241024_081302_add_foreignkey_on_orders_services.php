<?php

use yii\db\Migration;

/**
 * Class m241024_081302_add_foreignkey_on_orders_services
 */
class m241024_081302_add_foreignkey_on_orders_services extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx_orders_service_id',
            'orders',
            'service_id'
        );

        $this->addForeignKey(
            'fk_orders_service_id',
            'orders',
            'service_id',
            'services',
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
            'fk_orders_service_id',
            'orders'
        );

        $this->dropIndex(
            'idx_orders_service_id',
            'orders'
        );
    }
}
