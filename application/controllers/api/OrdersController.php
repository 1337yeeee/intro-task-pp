<?php

namespace app\controllers\api;

use app\models\Order;
use app\models\OrderFilter;
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
        $status = \Yii::$app->request->get('status'); // Параметр статуса
        $service_id = \Yii::$app->request->get('service_id'); // Параметр service_id
        $mode = \Yii::$app->request->get('mode'); // Параметр mode
        $page = \Yii::$app->request->get('page', 1); // Параметр страницы
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
            'perPage' => $perPage,
            'status' => $statusesNameToNum[$status]??null,
            'service_id' => $service_id,
            'mode' => $mode,
            'page' => $page,
            'searchQuery' => $searchQuery,
            'searchColumn' => $searchColumn,
        ];

        $ordersFilter = new OrderFilter($filters);
        $orders = Order::getRecentOrders($perPage, $page, $ordersFilter);
        $totalCount = Order::getCount($ordersFilter);

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
