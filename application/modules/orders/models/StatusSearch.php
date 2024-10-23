<?php

namespace orders\models;

use Yii;

/**
 * Represents statuses for order search
 */
class StatusSearch
{
    public const STATUSES = [
        '' => 'All orders',
        'pending' => 'Pending',
        'inprogress' => 'In progress',
        'completed' => 'Completed',
        'canceled' => 'Canceled',
        'error' => 'Error',
    ];

    /**
     * Returns the available statuses for orders.
     *
     * @return array
     */
    public function getStatuses(): array
    {
        return array_map(function ($value) {
            return Yii::t('app', $value);
        }, self::STATUSES);
    }

}
