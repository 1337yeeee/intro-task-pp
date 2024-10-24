<?php

namespace orders\services;

use yii\data\Pagination;
use yii\web\Request;

/**
 * Service for assembling an instance of yii\data\Pagination
 */
class OrderPaginationService
{
    /** @var Request */
    private Request $request;

    /** @var int */
    private int $defaultLimit;

    /** @var int */
    private int $defaultPage;

    /** @var string */
    private string $route;

    public function __construct(Request $request, int $defaultLimit, int $defaultPage, string $route)
    {
        $this->request = $request;
        $this->defaultLimit = $defaultLimit;
        $this->defaultPage = $defaultPage;
        $this->route = $route;
    }

    /**
     * Returns an instance of Pagination class with prepared parameters
     *
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        $perPage = $this->request->get('limit', $this->defaultLimit);
        $page = $this->request->get('page', $this->defaultPage);

        return new Pagination([
            'totalCount' => 0, // Controller will set this value
            'pageSize' => $perPage,
            'page' => $page - 1,
            'route' => $this->route
        ]);
    }
}
