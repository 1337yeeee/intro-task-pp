<?php

namespace orders\models;

use Yii;

/**
 * Class Mode
 * Handles order modes
 */
class Mode
{
    public const MODES = [
        '' => 'All',
        '0' => 'Manual',
        '1' => 'Auto',
    ];

    /**
     * Returns translated modes for orders.
     *
     * @return array
     */
    public static function getModes(): array
    {
        return array_map(function ($value) {
            return Yii::t('app', $value);
        }, self::MODES);
    }

    /**
     * Returns translated mode by key
     *
     * @param string $key
     * @return string
     */
    public static function getModeLabel(string $key): string
    {
        return isset(self::MODES[$key]) ? Yii::t('app', self::MODES[$key]) : '';
    }
}

