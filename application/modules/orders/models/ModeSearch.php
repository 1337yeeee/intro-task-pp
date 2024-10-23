<?php

namespace app\modules\orders\models;

use Yii;

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
