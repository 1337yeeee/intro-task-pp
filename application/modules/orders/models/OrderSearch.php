<?php

namespace app\modules\orders\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveRecord;

/**
 * Decorator for Order model for applying filters
 */
class OrderSearch extends Order
{
    public $search = '';
    public $search_type = 0;
    public $page;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['status', 'search', 'search_type', 'service_id', 'page', 'mode'], 'safe'],
            ['status', 'in', 'range' => array_keys($this->getStatuses())],
            ['mode', 'in', 'range' => array_keys($this->getModeModel()::MODES)],
            ['service_id', 'integer'],
            ['page', 'integer', 'min' => 1],
            ['search_type', 'integer'],
            ['search', 'string'],
        ];
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function beforeValidate(): bool
    {
        $statuses = $this->getStatuses();

        if (isset($this->status) && is_string($this->status)) {
            $this->status = array_search($this->status, $statuses, true);
        }

        return parent::beforeValidate();
    }

    /**
     * @inheritDoc
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Search orders with passed filters and pagination
     *
     * @param array $params
     * @param Pagination|null $pagination
     * @return ActiveDataProvider
     */
    public function search(array $params, Pagination $pagination): ActiveDataProvider
    {
        $query = self::find()
            ->joinWith(['service', 'user'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($pagination->getLimit())
            ->offset($pagination->getOffset());

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
        ]);

        if ($this->load($params, '') and $this->validate()) {
            $filter = new OrderFilter($this);
            $filter->applyFilters($query);
        }

        return $dataProvider;
    }

    /**
     * Returns the list of services and their quantities given the filters
     *
     * @param array $params
     * @return array|ActiveRecord[]
     */
    public function getServicesOfOrders(array $params): array
    {
        $query = self::find()
            ->joinWith('service')
            ->select(['services.name', 'services.id', 'COUNT(orders.id) as order_count'])
            ->groupBy(new \yii\db\Expression('`services`.`name`, `services`.`id` WITH ROLLUP'))
            ->having('services.id IS NOT NULL OR services.name IS NULL')
            ->orderBy(['order_count' => SORT_DESC]);

        if ($this->load($params, '') and $this->validate()) {
            $filter = new OrderFilter($this, ['service_id']);
            $filter->applyFilters($query);
        }

        return $query->asArray()->all();
    }

    /**
     * Get count of filtered orders
     *
     * @param array $params
     * @return bool|int|string|null
     */
    public function getCount(array $params)
    {
        $query = self::find();

        if ($this->load($params, '') and $this->validate()) {
            $filter = new OrderFilter($this);
            $filter->applyFilters($query);
        }

        return $query->count();
    }

    /**
     * Iterate through orders applying batch size
     *
     * @param int $batchSize
     * @param OrderFilter|null $filter
     * @return \Generator
     */
    public function getRecentOrdersBatch(int $batchSize = 100, array $params = []): \Generator
    {
        $query = (new \yii\db\Query())
            ->select([
                'orders.id', 'orders.status', 'orders.mode', 'orders.link',
                'orders.quantity', 'orders.created_at', 'users.first_name',
                'users.last_name', 'services.name service_name',
            ])
            ->from('orders')
            ->join('LEFT JOIN', 'services', 'services.id = orders.service_id')
            ->join('LEFT JOIN', 'users', 'users.id = orders.user_id')
            ->orderBy(['orders.id' => SORT_DESC]);

        if ($this->load($params, '') and $this->validate()) {
            $filter = new OrderFilter($this);
            $filter->setDoJoin(false);
            $filter->applyFilters($query);
        }

        foreach ($query->batch($batchSize) as $ordersBatch) {
            yield $ordersBatch;
        }
    }

    /**
     * Provides a ModeSearch model
     */
    public function getModeModel(): ModeSearch
    {
        return new ModeSearch();
    }

    /**
     * Provides a StatusSearch model
     *
     * @return StatusSearch
     */
    public function getStatusModel(): StatusSearch
    {
        return new StatusSearch();
    }

    /**
     * @inheritdoc
     */
    public function attributes(): array
    {
        return array_merge(parent::attributes(), ['search', 'search_type']);
    }
}
