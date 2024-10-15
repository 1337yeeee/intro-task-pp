<?php

namespace app\controllers\api;

use app\models\Order;
use yii\rest\Controller;
use Yii;

class OrdersController extends Controller
{
    /**
     * Метод для получения статических заказов.
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $perPage = \Yii::$app->request->get('limit', 100); // Параметр лимита, по умолчанию 100
        $status = \Yii::$app->request->get('status'); // Параметр статуса
        $service_id = \Yii::$app->request->get('service_id'); // Параметр service_id
        $mode = \Yii::$app->request->get('mode'); // Параметр mode
        $page = \Yii::$app->request->get('page', 1); // Параметр страницы

        $statuses = [
            'Pending' => 0,
            'In progress' => 1,
            'Completed' => 2,
            'Canceled' => 3,
            'Fail' => 4,
        ];
        $status = $statuses[$status] ?? null;

        $orders = Order::getRecentOrders($perPage, $status, $service_id, $mode, $page);

        $totalCount = Order::getCount($status, $service_id, $mode);

        return $this->asJson([
            'total_count' => $totalCount,
            'per_page' => $perPage,
            'page' => $page,
            'orders' => $orders,
        ]);
    }
}
