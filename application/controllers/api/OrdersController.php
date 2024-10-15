<?php

namespace app\controllers\api;

use yii\rest\Controller;
use Yii;

class OrdersController extends Controller
{
    /**
     * Метод для получения статических заказов.
     *
     * @return array
     */
    public function actionIndex()
    {
        // Статические данные о заказах
        $orders = [
            [
                'id' => 1,
                'user_id' => 1,
                'user' => [
                    'id' => 1,
                    'first_name' => 'FN1',
                    'last_name' => 'LN1'
                ],
                'link' => 1,
                'quantity' => 1,
                'service_id' => 1,
                'service' => [
                    'id' => 1,
                    'name' => 'S1'
                ],
                'status' => 1,
                'created_at' => 1,
                'mode' => 1,
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'user' => [
                    'id' => 2,
                    'first_name' => 'FN2',
                    'last_name' => 'LN2'
                ],
                'link' => 2,
                'quantity' => 2,
                'service_id' => 2,
                'service' => [
                    'id' => 2,
                    'name' => 'S2'
                ],
                'status' => 2,
                'created_at' => 2,
                'mode' => 1,
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'user' => [
                    'id' => 3,
                    'first_name' => 'FN3',
                    'last_name' => 'LN3'
                ],
                'link' => 3,
                'quantity' => 3,
                'service_id' => 3,
                'service' => [
                    'id' => 3,
                    'name' => 'S3'
                ],
                'status' => 3,
                'created_at' => 3,
                'mode' => 0,
            ],
        ];

        // Возвращаем статические данные в формате JSON
        return $orders;
    }
}
