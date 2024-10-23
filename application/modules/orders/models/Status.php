<?php

namespace orders\models;

use Yii;

/**
 * Class Status
 * Handles order statuses
 */
class Status
{
    // ID => status key
    public const STATUSES = [
        0 => 'pending',
        1 => 'inprogress',
        2 => 'completed',
        3 => 'canceled',
        4 => 'error',
    ];

    public const EMPTY_STATUS_LABEL = 'All';

    /**
     * Returns translated statuses with labels.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return array_map(function ($value) {
            return Yii::t('app', $value);
        }, self::STATUSES);
    }

    /**
     * Returns status label by status key.
     *
     * @param int $key
     * @return string
     */
    public static function getStatusLabel(int $key): string
    {
        return isset(self::STATUSES[$key]) ? Yii::t('app', self::STATUSES[$key]) : '';
    }

    /**
     * Returns the status key by value (for filtering).
     *
     * @param string $statusValue
     * @return int|null
     */
    public static function getStatusKey(string $statusValue): ?int
    {
        $status = array_search($statusValue, self::STATUSES, true);
        return $status !== false ? $status : '';
    }

    /**
     * Return statuses formated as 'pending' => 'Pending'.
     *
     * @return array
     */
    public static function getStatusesWithKeys(): array
    {
        $statuses = self::getStatuses();
        $statusesWithKeys[''] = Yii::t('app', self::EMPTY_STATUS_LABEL);
        $statusesWithKeys += array_combine(self::STATUSES, $statuses);
        return $statusesWithKeys;
    }
}
