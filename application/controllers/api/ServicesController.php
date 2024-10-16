<?php

namespace app\controllers\api;

use app\models\OrderFilter;
use yii\rest\Controller;
use app\models\Service;
use app\models\Order;

class ServicesController extends Controller
{
    public function actionIndex()
    {
        $status = \Yii::$app->request->get('status'); // Параметр статуса
        $service_id = \Yii::$app->request->get('service_id'); // Параметр service_id
        $mode = \Yii::$app->request->get('mode'); // Параметр mode
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
            'status' => $statusesNameToNum[$status]??null,
            'service_id' => $service_id,
            'mode' => $mode,
            'searchQuery' => $searchQuery,
            'searchType' => $searchType,
            'searchColumn' => $searchColumn,
        ];
        $filter = new OrderFilter($filters);

        $services = Order::getServicesOfOrders($filter);

        $totalCount = Order::getCount($filter);

        return $this->asJson([
            'totalCount' => $totalCount,
            'services' => $services,
        ]);
    }
}
