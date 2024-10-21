<?php

namespace app\modules\orders\controllers;

use app\modules\orders\services\OrderCsvExportService;
use app\modules\orders\services\OrderFilterService;
use app\modules\orders\services\OrderPaginationService;
use Yii;
use yii\web\Controller;

/**
 * Controller for orders
 */
class OrderController extends Controller
{
    private const DEFAULT_LIMIT = 100;
    private const DEFAULT_PAGE = 1;
    private const INDEX_ROUTE = 'orders/index';

    /**
     * Display filtered orders.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $paginationService = new OrderPaginationService(Yii::$app->request, self::DEFAULT_LIMIT, self::DEFAULT_PAGE, self::INDEX_ROUTE);
        $pagination = $paginationService->getPagination();

        $filterService = new OrderFilterService();
        $filteredOrders = $filterService->getFilteredOrders($pagination);

        return $this->render('index', [
            'dataProvider' => $filteredOrders['dataProvider'],
            'searchModel' => $filteredOrders['searchModel'],
            'servicesList' => $filteredOrders['servicesList'],
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
