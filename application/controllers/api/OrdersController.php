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
        $orders = Order::getRecentOrders();
        return $this->asJson($orders);
    }
}
