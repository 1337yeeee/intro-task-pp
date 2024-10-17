<?php

namespace app\services;

use app\models\OrderFilter;

class OrderFilterService
{
    private array $filtersIgnore = [];
    public function filterIgnore(array $filters)
    {
        foreach ($filters as $filter) {
            $this->filtersIgnore[$filter] = 1;
        }
    }
    public function getFilter(): OrderFilter
    {
        $status = \Yii::$app->request->get('status'); // Параметр статуса
        $service_id = \Yii::$app->request->get('service_id'); // Параметр service_id
        $mode = \Yii::$app->request->get('mode'); // Параметр mode
        $searchQuery = \Yii::$app->request->get('search'); // Параметр страницы
        $searchType = \Yii::$app->request->get('search-type', 1);

        switch($searchType) {
            case 2:
                $searchColumn = 'link';
                break;
            case 3:
                $searchColumn = 'users';
                break;
            default:
                $searchColumn = 'id';
        }

        $statusesNameToNum = [
            'Pending'=> 0,
            'In progress'=> 1,
            'Completed'=> 2,
            'Canceled'=> 3,
            'Error'=> 4,
        ];

        $filters = [
            'status' => isset($this->filtersIgnore['status']) && $this->filtersIgnore['status'] ? null : ($statusesNameToNum[$status] ?? null),
            'service_id' => isset($this->filtersIgnore['service_id']) && $this->filtersIgnore['service_id'] ? null : $service_id,
            'mode' => isset($this->filtersIgnore['mode']) && $this->filtersIgnore['mode'] ? null : $mode,
            'searchQuery' => isset($this->filtersIgnore['search']) && $this->filtersIgnore['search'] ? null : $searchQuery,
            'searchColumn' => $searchColumn,
        ];

        $filter = new OrderFilter($filters);

        return $filter;
    }
}
