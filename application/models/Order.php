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

}
