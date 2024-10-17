<?php

namespace app\services;

use app\models\Order;
use app\models\OrderFilter;
use Yii;

class OrderService
{
    public function getRecentOrders(int $page=1, int $limit=100, ?OrderFilter $filter=null) : array
    {
        $offset = ($page - 1) * $limit;

        $query = Order::find()
            ->joinWith(['service','user'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit)
            ->offset($offset);

        if($filter!==null) $filter->applyFilters($query);
//        echo $query->createCommand()->rawSql;exit;
        return $query->asArray()->all();
    }

    public function getRecentOrdersBatch(int $batchSize = 1000, ?OrderFilter $filter = null)
    {
        $query = Order::find()
            ->joinWith(['service', 'user'])
            ->orderBy(['id' => SORT_DESC]);

        if ($filter !== null) {
            $filter->applyFilters($query);
        }

        foreach ($query->batch($batchSize) as $ordersBatch) {
            yield $ordersBatch;
        }
    }

    public function getCount(?OrderFilter $filter=null)
    {
        $query = Order::find();

        if($filter!==null) $filter->applyFilters($query);

        return $query->count();
    }

    public function getServicesOfOrders(?OrderFilter $filter=null)
    {
        $query = Order::find()
            ->joinWith('service')
            ->select(['services.name', 'services.id', 'COUNT(orders.id) as order_count'])
            ->groupBy(['services.name', 'services.id'])
            ->orderBy(['order_count' => SORT_DESC]);

        $filter->applyFilters($query);

        return $query->asArray()->all();
    }
}
