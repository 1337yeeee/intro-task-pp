<?php


namespace orders\services;

use orders\models\OrderSearch;
use yii\data\Pagination;

/**
 * Assembles an OrderFilter from GET request
 */
class OrderFilterService
{
    private array $filtersIgnore = [];

    public function getFilteredOrders(array $params, Pagination $pagination): array
    {
        $searchModel = new OrderSearch();

        $totalCount = $searchModel->getCount($params);
        $pagination->totalCount = $totalCount;

        $ordersDataProvider = $searchModel->search($params, $pagination);
        $servicesList = $searchModel->getServicesOfOrders($params);

        return [
            'dataProvider' => $ordersDataProvider,
            'servicesList' => $servicesList,
            'searchModel' => $searchModel,
        ];
    }

}
