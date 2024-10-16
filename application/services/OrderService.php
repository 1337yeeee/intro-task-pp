<?php

namespace app\services;

use app\models\Order;
use app\models\OrderFilter;
use Yii;
use yii\data\Pagination;

class OrderService
{
    public function getRecentOrders(Pagination $pagination, ?OrderFilter $filter=null) : array
    {
        $query = Order::find()
            ->joinWith(['service','user'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($pagination->getLimit())
            ->offset($pagination->getOffset());

        if($filter!==null) $filter->applyFilters($query);
        return $query->asArray()->all();
    }

    public function getRecentOrdersBatch(int $batchSize = 1000, ?OrderFilter $filter = null): \Generator
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

    public function getServicesOfOrders(?OrderFilter $filter=null): array
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
