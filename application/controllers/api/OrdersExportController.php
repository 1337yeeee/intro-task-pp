<?php

namespace app\controllers\api;

use app\services\OrderFilterService;
use app\services\OrderService;
use Yii;
use yii\web\Controller;
use app\models\Order;

class OrdersExportController extends Controller
{
    public function actionCsv()
    {
        $this->setCsvHeaders();

        $output = fopen('php://output', 'w');

        fputcsv($output, $this->getCsvHeaders());

        $service = new OrderService();

        $filterService = new OrderFilterService();
        $ordersFilter = $filterService->getFilter();

        foreach ($service->getRecentOrdersBatch(10000, $ordersFilter) as $orders) {
            foreach ($orders as $order) {
                fputcsv($output, $this->getOrderForCSV($order));
            }
        }

        fclose($output);
        exit;
    }

    private function setCsvHeaders(): void
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
    }

    private function getOrderForCSV(Order $order): array
    {
        // Получаем имя пользователя
        $userName = isset($order->user)
            ? ($order->user->first_name ?? '') . ' ' . ($order->user->last_name ?? '')
            : '';

        // Получаем имя сервиса
        $service = isset($order->service)
            ? $order->service->name ?? ''
            : '';

        // Получаем статус, режим и дату создания
        $status = $order->getStatus();
        $mode = $order->getMode();
        $date = \date('Y-m-d H:i:s', $order->created_at);

        return [
            $order->id ?? '',          // Используем объектный доступ к атрибутам
            $userName,
            $order->link ?? '',
            $order->quantity ?? '',
            $service,
            $status,
            $mode,
            $date,
        ];
    }

    private function getCsvHeaders(): array
    {
        return [
            Yii::t('app', 'ID'),
            Yii::t('app', 'User'),
            Yii::t('app', 'Link'),
            Yii::t('app', 'Quantity'),
            Yii::t('app', 'Service'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'Mode'),
            Yii::t('app', 'Created'),
        ];
    }
}
