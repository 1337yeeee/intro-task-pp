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
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        fputcsv($output, $this->getCsvHeaders());

        $service = new OrderService();

        $filterService = new OrderFilterService();
        $ordersFilter = $filterService->getFilter();

        foreach ($service->getRecentOrdersBatch(1000, $ordersFilter) as $orders) {
            foreach ($orders as $order) {
                fputcsv($output, $this->getOrderForCSV($order));
            }
        }

        fclose($output);
        exit;
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
        $status = $this->getStatus($order->status);
        $mode = $this->getMode($order->mode);
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

    private static array $modes;
    private function getMode($mode): string
    {
        if(isset(self::$modes)) return self::$modes[$mode]??'';
        self::$modes = [
            0 => Yii::t('app', 'Manual'),
            1 => Yii::t('app', 'Auto'),
        ];
        return self::$modes[$mode]??'';
    }

    private static array $statuses;
    private function getStatus($status): string
    {
        if(isset(self::$statuses)) return self::$statuses[$status]??'';
        self::$statuses = [
            0 => Yii::t('app', 'Pending'),
            1 => Yii::t('app', 'In progress'),
            2 => Yii::t('app', 'Completed'),
            3 => Yii::t('app', 'Canceled'),
            4 => Yii::t('app', 'Error'),
        ];
        return self::$statuses[$status]??'';
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
