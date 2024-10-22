<?php

namespace app\modules\orders\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Model of `orders` table
 */
class Order extends ActiveRecord
{

    private const MODES = [
        0 => 'Manual',
        1 => 'Auto',
    ];

    private const STATUSES = [
        0 => 'Pending',
        1 => 'In progress',
        2 => 'Completed',
        3 => 'Canceled',
        4 => 'Error',
    ];

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'orders';
    }

    /**
     * Get the user of this order
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Get the service of this order
     *
     * @return ActiveQuery
     */
    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * Returns mode as a string of this order
     *
     * @return string
     */
    public function getMode(): string
    {
        $modeValue = $this->getAttribute('mode');

        if (isset(self::MODES[$modeValue])) {
            return Yii::t('app', self::MODES[$modeValue]);
        }

        return '';
    }

    /**
     * Returns status as a string of this order
     *
     * @return string
     */
    public function getStatus(): string
    {
        $statusValue = $this->getAttribute('status');
        if (isset(self::STATUSES[$statusValue])) {
            return Yii::t('app', self::STATUSES[$statusValue]);
        }

        return '';
    }

    public function getStatuses(): array
    {
        return array_map(function ($value) {
            return Yii::t('app', $value);
        }, self::STATUSES);
    }

    public function getModes(): array
    {
        return array_map(function ($key, $value) {
            return Yii::t('app', $value);
        }, self::MODES);
    }

}
