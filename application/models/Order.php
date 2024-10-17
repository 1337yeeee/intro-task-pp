<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

     public static function getRecentOrders(int $limit = 100, int $page = 1, ?OrderFilter $filter=null): array
    {
        $offset = ($page - 1) * $limit;

        $query = self::find()
            ->joinWith(['service','user'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit)
            ->offset($offset);

        if($filter!==null) $filter->applyFilters($query);

        return $query->asArray()->all();
    }


    public static function getCount(?OrderFilter $filter=null)
    {
        $query = self::find();

        if($filter!==null) $filter->applyFilters($query);

        return $query->count();
    }

    public static function getServicesOfOrders(?OrderFilter $filter=null)
    {
        $query = self::find()
            ->joinWith('service')
            ->select(['services.name', 'services.id', 'COUNT(orders.id) as order_count'])
            ->groupBy(['services.name', 'services.id']);

        $filter->applyFilters($query);

        return $query->asArray()->all();
    }

    private static array $modes;
    public function getMode(): string
    {
        $modeValue = $this->getAttribute('mode');
        if(isset(self::$modes)) return self::$modes[$modeValue]??'';
        self::$modes = [
            0 => Yii::t('app', 'Manual'),
            1 => Yii::t('app', 'Auto'),
        ];
        return self::$modes[$modeValue]??'';
    }

    private static array $statuses;
    public function getStatus(): string
    {
        $statusValue = $this->getAttribute('status');
        if(isset(self::$statuses)) return self::$statuses[$statusValue]??'';
        self::$statuses = [
            0 => Yii::t('app', 'Pending'),
            1 => Yii::t('app', 'In progress'),
            2 => Yii::t('app', 'Completed'),
            3 => Yii::t('app', 'Canceled'),
            4 => Yii::t('app', 'Error'),
        ];
        return self::$statuses[$statusValue]??'';
    }

}
