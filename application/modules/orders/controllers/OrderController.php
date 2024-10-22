<?php

namespace orders\controllers;

use app\modules\orders\services\OrderCsvExportService;
use app\modules\orders\services\OrderFilterService;
use app\modules\orders\services\OrderPaginationService;
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
    private const DEFAULT_ROUTE = 'index';
    private const INDEX_ROUTE = 'orders';

    /**
     * Display filtered orders.
     *
     * @param string|null $status
     * @return string
     */
    public function actionIndex(?string $status = null): string
    {
        $route = self::INDEX_ROUTE . '/' . ($status ?: self::DEFAULT_ROUTE);
        $paginationService = new OrderPaginationService(Yii::$app->request, self::DEFAULT_LIMIT, self::DEFAULT_PAGE, $route);
        $pagination = $paginationService->getPagination();

        $filterService = new OrderFilterService();
        $filteredOrders = $filterService->getFilteredOrders($pagination);

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
        $csvExportService->exportToCsv();
        exit;
    }
}
