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
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['status', 'service_id', 'mode'], 'safe'],
            ['status', 'in', 'range' => array_keys(Status::STATUSES)],
            ['mode', 'in', 'range' => array_keys(Mode::MODES)],
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
        return Mode::getModeLabel($modeValue);
    }

    /**
     * Returns status as a string of this order
     *
     * @return string
     */
    public function getStatus(): string
    {
        $statusValue = $this->getAttribute('status');
        return Status::getStatus($statusValue);
    }

    /**
     * Returns statuses which may be  set to order
     *
     * @return string[]
     */
    public function getStatuses(): array
    {
        return Status::getStatuses();
    }

    /**
     * Returns modes which may be set to order
     *
     * @return array
     */
    public function getModes(): array
    {
        return Mode::getModes();
    }

}
