<?php

namespace app\modules\orders\services;

use yii\data\Pagination;
use yii\web\Request;

class OrderPaginationService
{
    private $request;
    private $defaultLimit;
    private $defaultPage;
    private $route;

    public function __construct(Request $request, int $defaultLimit, int $defaultPage, string $route)
    {
        $this->request = $request;
        $this->defaultLimit = $defaultLimit;
        $this->defaultPage = $defaultPage;
        $this->route = $route;
    }

    public function getPagination(): Pagination
    {
        $perPage = $this->request->get('limit', $this->defaultLimit);
        $page = $this->request->get('page', $this->defaultPage);

        return new Pagination([
            'totalCount' => 0, // Это значение позже будет установлено через фильтр
            'pageSize' => $perPage,
            'page' => $page - 1,
            'route' => $this->route
        ]);
    }
}
