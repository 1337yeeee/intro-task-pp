<?php


namespace app\modules\orders\services;

use app\modules\orders\models\OrderFilter;
use app\modules\orders\models\OrderSearch;
use Yii;

/**
 * Assembles an OrderFilter from GET request
 */
class OrderFilterService
{
    private array $filtersIgnore = [];

    public function getFilteredOrders($pagination): array
    {
        $searchModel = new OrderSearch();

        $filter = $this->getFilter();
        $totalCount = $searchModel->getCount($filter);

        // Установим правильное значение totalCount для пагинации
        $pagination->totalCount = $totalCount;

        $ordersDataProvider = $searchModel->search($pagination, $filter);

        // Игнорируем определенные фильтры
        $this->filterIgnore(['service_id']);
        $filter = $this->getFilter();
        $servicesList = $searchModel->getServicesOfOrders($filter);

        return [
            'dataProvider' => $ordersDataProvider,
            'searchModel' => $searchModel,
            'servicesList' => $servicesList,
        ];
    }

    /**
     * Ignore specified parameters
     *
     * @param array $filters
     */
    public function filterIgnore(array $filters): void
    {
        foreach ($filters as $filter) {
            $this->filtersIgnore[$filter] = true;
        }
    }

    /**
     * Returns an instance of OrderFilter
     *
     * @return OrderFilter
     */
    public function getFilter(): OrderFilter
    {
        $filters = [
            'status' => $this->getStatusFilter(),
            'service_id' => $this->getFilterParam('service_id'),
            'mode' => $this->getFilterParam('mode'),
            'searchQuery' => $this->getFilterParam('search'),
            'searchColumn' => $this->getSearchColumn(),
        ];

        return new OrderFilter($filters);
    }

    /**
     * Get filter parameter from GET request if it is not ignored
     *
     * @param string $param
     * @return mixed|null
     */
    private function getFilterParam(string $param)
    {
        if (isset($this->filtersIgnore[$param]) && $this->filtersIgnore[$param]) {
            return null;
        }
        return Yii::$app->request->get($param);
    }

    /**
     * Get filter by order's status
     *
     * @return int|null
     */
    private function getStatusFilter(): ?int
    {
        if ($this->isFilterIgnored('status')) {
            return null;
        }

        $status = Yii::$app->request->get('status');
        $statusesNameToNum = $this->getStatusesMap();

        return $statusesNameToNum[$status] ?? null;
    }

    /**
     * Map of statuses fo filtration
     *
     * @return array
     */
    private function getStatusesMap(): array
    {
        return [
            'Pending' => 0,
            'In progress' => 1,
            'Completed' => 2,
            'Canceled' => 3,
            'Error' => 4,
        ];
    }

    /**
     * Determine by what column search will be applied
     *
     * @return string
     */
    private function getSearchColumn(): string
    {
        $searchType = Yii::$app->request->get('search_type', 1);

        switch ($searchType) {
            case 1:
                $column = 'link';
                break;
            case 2:
                $column = 'user';
                break;
            default:
                $column = 'id';
        }

        return $column;
    }

    /**
     * Check if the passed filter is ignored
     *
     * @param string $filter
     * @return bool
     */
    private function isFilterIgnored(string $filter): bool
    {
        return isset($this->filtersIgnore[$filter]) && $this->filtersIgnore[$filter];
    }
}
