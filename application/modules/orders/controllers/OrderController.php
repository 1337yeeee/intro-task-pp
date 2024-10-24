<?php

namespace orders\controllers;

use orders\services\OrderCsvExportService;
use orders\services\OrderFilterService;
use orders\services\OrderPaginationService;
use yii\helpers\Url;
use Yii;
use yii\web\Controller;

/**
 * Controller for orders
 */
class OrderController extends Controller
{
    private const DEFAULT_LIMIT = 100;
    private const DEFAULT_PAGE = 1;

    /**
     * Display filtered orders.
     *
     * @param string|null $status
     * @return string
     */
    public function actionIndex(?string $status = null): string
    {
        $route = Url::to(['', 'status' => $status]);
        $paginationService = new OrderPaginationService(Yii::$app->request, self::DEFAULT_LIMIT, self::DEFAULT_PAGE, $route);
        $pagination = $paginationService->getPagination();

        $filterService = new OrderFilterService();
        $filteredOrders = $filterService->getFilteredOrders(Yii::$app->request->queryParams, $pagination);

        $exportPath = Url::to(array_merge(['order/csv'], Yii::$app->request->queryParams));

        return $this->render('index', [
            'dataProvider' => $filteredOrders['dataProvider'],
            'servicesList' => $filteredOrders['servicesList'],
            'searchModel' => $filteredOrders['searchModel'],
            'exportPath' => $exportPath,
        ]);
    }

    /**
     * Export orders to CSV.
     */
    public function actionCsv()
    {
        $csvExportService = new OrderCsvExportService();
        $csvExportService->exportToCsv(Yii::$app->request->queryParams);
        exit;
    }
}
