<?php

namespace app\modules\orders\services;

use app\modules\orders\models\OrderSearch;
use app\modules\orders\models\Order;

/**
 * Service for exporting filtered orders in a csv file
 */
class OrderCsvExportService
{
    /**
     * Exports a CSV file with filtered data
     *
     * @return void
     */
    public function exportToCsv(): void
    {
        $this->setCsvHeaders();

        $output = fopen('php://output', 'w');
        fputcsv($output, $this->getCsvHeaders());

        $searchModel = new OrderSearch();
        $filterService = new OrderFilterService();
        $ordersFilter = $filterService->getFilter();

        foreach ($searchModel->getRecentOrdersBatch(100, $ordersFilter) as $ordersBatch) {
            foreach ($ordersBatch as $order) {
                fputcsv($output, $this->getOrderForCSV($order));
                flush();
            }
        }

        fclose($output);
    }

    /**
     * Sets HTTP headers for sending the scv file
     *
     * @return void
     */
    private function setCsvHeaders(): void
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
    }

    /**
     * Returns headers for the csv file
     *
     * @return string[]
     */
    private function getCsvHeaders(): array
    {
        return [
            'ID', 'User', 'Link', 'Quantity', 'Service', 'Status', 'Mode', 'Created'
        ];
    }

    /**
     * Returns an array that will be written in the csv file
     *
     * @param Order $order
     * @return array
     */
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
