<?php

namespace app\controllers\api;

use app\models\OrderFilter;
use app\services\OrderService;
use app\services\OrderFilterService;
use yii\rest\Controller;
use app\models\Service;
use app\models\Order;

class ServicesController extends Controller
{
    public function actionIndex()
    {
        $filterService = new OrderFilterService();
        $filterService->filterIgnore(['service_id']);
        $filter = $filterService->getFilter();

        $orderService = new OrderService();
        $services = $orderService->getServicesOfOrders($filter);

        $totalCount = $orderService->getCount($filter);

        return $this->asJson([
            'totalCount' => $totalCount,
            'services' => $services,
        ]);
    }
}
