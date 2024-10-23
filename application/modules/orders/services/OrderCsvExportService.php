<?php

namespace orders\services;

use orders\models\OrderSearch;

/**
 * Service for exporting filtered orders in a csv file
 */
class OrderCsvExportService
{
    /**
     * Exports a CSV file with filtered data
     *
     * @param array $params
     * @return void
     */
    public function exportToCsv(array $params): void
    {
        $this->setCsvHeaders();

        $output = fopen('php://output', 'w');
        fputcsv($output, $this->getCsvHeaders());

        $searchModel = new OrderSearch();

        foreach ($searchModel->getRecentOrdersBatch(10, $params) as $ordersBatch) {
            foreach ($ordersBatch as $order) {
                fputcsv($output, $this->getOrderForCSV($order));
                flush();
                unset($order);
            }
            unset($ordersBatch);
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
     * @param array $order
     * @return array
     */
    private function getOrderForCSV(array $order): array
    {
        $userName = ($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? '');
        $service = $order['service_name'] ?? '';
        $status = $order['status'];
        $mode = $order['mode'];
        $date = \date('Y-m-d H:i:s', $order['created_at']);

        return [
            $order['id'] ?? '',
            $userName,
            $order['link'] ?? '',
            $order['quantity'] ?? '',
            $service,
            $status,
            $mode,
            $date,
        ];
    }
}
