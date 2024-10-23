<?php

namespace orders\models;

use Yii;

/**
 * Model represents modes of order
 */
class ModeSearch
{
    public const MODES = [
        '' => 'All',
        '0' => 'Manual',
        '1' => 'Auto',
    ];

    /**
     * Returns the available modes for orders.
     *
     * @return array
     */
    public function getModes(): array
    {
        return array_map(function ($value) {
            return Yii::t('app', $value);
        }, self::MODES);
    }

}
