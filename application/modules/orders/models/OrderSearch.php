<?php

namespace orders\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\QueryInterface;

/**
 * Decorator for Order model for applying filters
 */
class OrderSearch extends Order
{
    /**
     * @var string
     */
    public $search = '';

    /**
     * @var int
     */
    public $search_type = 0;

    /**
     * @var int
     */
    public $page;

    public const SEARCH_TYPE_ID = 0;
    public const SEARCH_TYPE_ID_LABEL = 'Order ID';
    public const SEARCH_TYPE_LINK = 1;
    public const SEARCH_TYPE_LINK_LABEL = 'Link';
    public const SEARCH_TYPE_USERNAME = 2;
    public const SEARCH_TYPE_USERNAME_LABEL = 'Username';
    public const TEXT_INPUT_PLACEHOLDER = 'Search orders';

    public const ID_LABEL = 'ID';
    public const USER_LABEL = 'User';
    public const LINK_LABEL = 'Link';
    public const QUANTITY_LABEL = 'Quantity';
    public const STATUS_LABEL = 'Status';
    public const CREATED_AT_LABEL = 'Created';

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['status', 'search', 'search_type', 'service_id', 'page', 'mode'], 'safe'],
            ['status', 'in', 'range' => array_keys($this->getStatuses())],
            ['mode', 'in', 'range' => array_keys($this->getModes())],
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
        if (isset($this->status) && is_string($this->status)) {
            $this->status = Status::getStatusKey($this->status);
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
        $query = $this->buildQuery()
            ->orderBy(['id' => SORT_DESC])
            ->limit($pagination->getLimit())
            ->offset($pagination->getOffset());

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
        ]);

        $this->applyFiltersIfValid($params, $query);

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
        $query = $this->buildQuery()
            ->select(['services.name', 'services.id', 'COUNT(orders.id) as order_count'])
            ->groupBy(new \yii\db\Expression('`services`.`name`, `services`.`id` WITH ROLLUP'))
            ->having('services.id IS NOT NULL OR services.name IS NULL')
            ->orderBy(['order_count' => SORT_DESC]);

        $this->applyFiltersIfValid($params, $query, ['service_id']);

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
        $query = $this->buildQueryJoin();

        $this->applyFiltersIfValid($params, $query);

        return $query->count();
    }

    /**
     * Iterate through orders applying batch size
     *
     * @param int $batchSize
     * @param array $params
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
            ->orderBy(['orders.id' => SORT_DESC]);

        $this->joinAll($query);

        $this->applyFiltersIfValid($params, $query);

        foreach ($query->batch($batchSize) as $ordersBatch) {
            yield $ordersBatch;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributes(): array
    {
        return array_merge(parent::attributes(), ['search', 'search_type']);
    }

    /**
     * Returns translated types of search
     *
     * @return array
     */
    public function getSearchTypes(): array
    {
        return [
            self::SEARCH_TYPE_ID => Yii::t('app', self::SEARCH_TYPE_ID_LABEL),
            self::SEARCH_TYPE_LINK => Yii::t('app', self::SEARCH_TYPE_LINK_LABEL),
            self::SEARCH_TYPE_USERNAME => Yii::t('app', self::SEARCH_TYPE_USERNAME_LABEL),
        ];
    }

    /**
     * Returns translated placeholder for search input
     *
     * @return string
     */
    public function getInputPlaceHolder(): string
    {
        return Yii::t('app', self::TEXT_INPUT_PLACEHOLDER);
    }

    /**
     * Joins Users and Services to the query
     *
     * @param QueryInterface $query
     * @return void
     */
    private function joinAll(QueryInterface $query): void
    {
        $query->leftJoin('users', 'users.id = orders.user_id');
        $query->leftJoin('services', 'services.id = orders.service_id');
    }

    /**
     * Builds the basic query with joined relations
     *
     * @return ActiveQuery
     */
    private function buildQuery(): ActiveQuery
    {
        return self::find()
            ->joinWith('service')
            ->joinWith('user');
    }

    /**
     * Builds the basic query and joins tables
     *
     * @return ActiveQuery
     */
    private function buildQueryJoin(): ActiveQuery
    {
        $query = self::find();
        $this->joinAll($query);
        return $query;
    }

    /**
     * Loads params into the model, validates it, then, if valid, applies filters to query
     *
     * @param array $params
     * @param QueryInterface $query
     * @param array $ingoreFields
     * @return void
     */
    private function applyFiltersIfValid(array $params, QueryInterface $query, array $ingoreFields = []): void
    {
        if ($this->load($params, '') && $this->validate()) {
            $filter = new OrderFilter($this, $ingoreFields);
            $filter->applyFilters($query);
        }
    }

}
