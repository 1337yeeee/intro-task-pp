<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    public static function tableName()
    {
        return 'services';
    }

    public static function getWithCount(OrderFilter $filter)
    {
        $query = self::find()
            ->select(['service.name', 'COUNT(order.id) as order_count'])
            ->joinWith('orders')
            ->groupBy('service.id');

        $filter->applyFilters($query);

        return $query->asArray()->all();
    }
}
