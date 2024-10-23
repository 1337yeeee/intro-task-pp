<?php

namespace orders\helpers;

use Yii;

/**
 * Helper for order-related labels.
 */
class OrderLabels
{
    public const ID_LABEL = 'ID';
    public const USER_LABEL = 'User';
    public const LINK_LABEL = 'Link';
    public const QUANTITY_LABEL = 'Quantity';
    public const STATUS_LABEL = 'Status';
    public const CREATED_AT_LABEL = 'Created';
    public const MODE_LABEL = 'Mode';
    public const SERVICE_LABEL = 'Service';
    public const ORDERS_LABEL = 'Orders';

    private static array $labels;

    /**
     * Returns translated labels
     *
     * @return array
     */
    public static function getLabels(): array
    {
        if (!isset(self::$labels)) {
            self::$labels = [
                'id' => Yii::t('app', self::ID_LABEL),
                'user' => Yii::t('app', self::USER_LABEL),
                'link' => Yii::t('app', self::LINK_LABEL),
                'quantity' => Yii::t('app', self::QUANTITY_LABEL),
                'status' => Yii::t('app', self::STATUS_LABEL),
                'created_at' => Yii::t('app', self::CREATED_AT_LABEL),
                'mode' => Yii::t('app', self::MODE_LABEL),
                'service' => Yii::t('app', self::SERVICE_LABEL),
                'orders' => Yii::t('app', self::ORDERS_LABEL),
            ];
        }

        return self::$labels;
    }

    /**
     * Returns the label for a given key, or an empty string if the key doesn't exist.
     *
     * @param string $key
     * @return string
     */
    public static function getLabel(string $key): string
    {
        $labels = self::getLabels();
        return $labels[$key] ?? $key;
    }
}
