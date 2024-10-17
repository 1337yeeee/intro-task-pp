<?php

namespace app\controllers\api;

use app\models\Order;
use app\models\OrderFilter;
use app\services\OrderService;
use app\services\OrderFilterService;
use yii\data\Pagination;
use yii\rest\Controller;
use Yii;
use yii\web\Response;
use yii\widgets\LinkPager;

class OrdersController extends Controller
{
    /**
     * Метод для получения статических заказов.
     *
     * @return Response
     * @throws \Throwable
     */
    public function actionIndex(): Response
    {
        $perPage = \Yii::$app->request->get('limit', 100); // Параметр лимита, по умолчанию 100
        $page = \Yii::$app->request->get('page', 1); // Параметр страницы

        $filterService = new OrderFilterService();
        $ordersFilter = $filterService->getFilter();

        $service = new OrderService();

        $orders = $service->getRecentOrders($page, $perPage, $ordersFilter);
        $totalCount = $service->getCount($ordersFilter);

        $pagination = LinkPager::widget([
            'pagination' => new Pagination([
                'totalCount' => $totalCount,
                'pageSize' => $perPage,
                'page' => $page - 1,
                'route' => 'orders/index'
            ]),
        ]);

        return $this->asJson([
            'total_count' => $totalCount,
            'per_page' => $perPage,
            'page' => $page,
            'pagination' => $pagination,
            'orders' => $orders,
        ]);
    }
}
