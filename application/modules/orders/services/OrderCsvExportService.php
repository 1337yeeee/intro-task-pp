<?php

namespace app\modules\orders\services;

use app\modules\orders\models\OrderSearch;
use app\modules\orders\models\Order;

class OrderCsvExportService
{
    public function exportToCsv(): void
    {
        $this->setCsvHeaders();

        $output = fopen('php://output', 'w');
        fputcsv($output, $this->getCsvHeaders());

        $searchModel = new OrderSearch();
        $filterService = new OrderFilterService();
        $ordersFilter = $filterService->getFilter($searchModel);

        $query = $searchModel->getRecentOrdersBatch2($ordersFilter);
        foreach ($query->batch(10000) as $ordersBatch) {
            foreach ($ordersBatch as $order) {
                fputcsv($output, $this->getOrderForCSV($order));
                flush();
            }
        }

        fclose($output);
    }

    private function setCsvHeaders(): void
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
    }

    private function getCsvHeaders(): array
    {
        return [
            'ID', 'User', 'Link', 'Quantity', 'Service', 'Status', 'Mode', 'Created'
        ];
    }

    private function getOrderForCSV(Order $order): array
    {
        $userName = isset($order->user)
            ? ($order->user->first_name ?? '') . ' ' . ($order->user->last_name ?? '')
            : '';

        $service = isset($order->service)
            ? $order->service->name ?? ''
            : '';

        $status = $order->getStatus();
        $mode = $order->getMode();
        $date = \date('Y-m-d H:i:s', $order->created_at);

        return [
            $order->id ?? '',
            $userName,
            $order->link ?? '',
            $order->quantity ?? '',
            $service,
            $status,
            $mode,
            $date,
        ];
    }
}
