<?php

namespace orders\models;

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
        0 => 'pending',
        1 => 'inprogress',
        2 => 'completed',
        3 => 'canceled',
        4 => 'error',
    ];

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['status', 'service_id', 'mode'], 'safe'],
            ['status', 'in', 'range' => array_keys(self::STATUSES)],
            ['mode', 'in', 'range' => array_keys(self::MODES)],
            ['service_id', 'integer'],
        ];
    }

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
            return self::STATUSES[$statusValue];
        }

        return '';
    }

    /**
     * Returns statuses which may be  set to order
     *
     * @return string[]
     */
    public function getStatuses(): array
    {
        return self::STATUSES;
    }

    /**
     * Returns modes which may be set to order
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
