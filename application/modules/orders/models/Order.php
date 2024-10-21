<?php

namespace app\modules\orders\models;

use app\modules\orders\models\OrderFilter;
use app\modules\orders\models\Service;
use app\modules\orders\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Model of `orders` table
 */
class Order extends ActiveRecord
{
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

    private static array $modes;

    /**
     * Returns mode as a string of this order
     *
     * @return string
     */
    public function getMode(): string
    {
        $modeValue = $this->getAttribute('mode');
        if (isset(self::$modes)) return self::$modes[$modeValue] ?? '';
        self::$modes = [
            0 => Yii::t('app', 'Manual'),
            1 => Yii::t('app', 'Auto'),
        ];
        return self::$modes[$modeValue] ?? '';
    }

    private static array $statuses;

    /**
     * Returns status as a string of this order
     *
     * @return string
     */
    public function getStatus(): string
    {
        $statusValue = $this->getAttribute('status');
        if (isset(self::$statuses)) return self::$statuses[$statusValue] ?? '';
        self::$statuses = [
            0 => Yii::t('app', 'Pending'),
            1 => Yii::t('app', 'In progress'),
            2 => Yii::t('app', 'Completed'),
            3 => Yii::t('app', 'Canceled'),
            4 => Yii::t('app', 'Error'),
        ];
        return self::$statuses[$statusValue] ?? '';
    }

}
