<?php

namespace orders\models;

use yii\db\QueryInterface;

/**
 * Class for applying filters on query which works with orders
 */
class OrderFilter
{
    private $params;
    public $status;
    public $service_id;
    public $mode;
    public $search;
    public $search_type;

    public const LINK_SEARCH_TYPE = '1';
    public const USER_SEARCH_TYPE = '2';

    public function __construct(OrderSearch $searchModel, array $ignore = [])
    {
        $params = [];
        foreach ($searchModel->getAttributes(null, $ignore) as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
                $params[$key] = $value;
            }
        }
        $this->params = $params;
    }

    /**
     * Applies filters on the query
     *
     * @param QueryInterface $query
     * @return void
     */
    public function applyFilters(QueryInterface $query)
    {
        if ($this->status !== null) {
            $query->andWhere(['orders.status' => $this->status]);
        }
        if ($this->service_id !== null) {
            $query->andWhere(['orders.service_id' => $this->service_id]);
        }
        if ($this->mode !== null) {
            $query->andWhere(['orders.mode' => $this->mode]);
        }
        if ($this->search !== null) {
            $this->applySearch($query);
        }
    }

    /**
     * Applies search filter if the parameters are set
     *
     * @param QueryInterface $query
     * @return void
     */
    protected function applySearch(QueryInterface $query)
    {
        $searchConditions = [];
        if ($this->search_type === self::LINK_SEARCH_TYPE) {
            $searchConditions[] = ['like', 'orders.link', $this->search];
        } elseif ($this->search_type === self::USER_SEARCH_TYPE) {
            $searchConditions[] = ['like', 'users.first_name', $this->search];
            $searchConditions[] = ['like', 'users.last_name', $this->search];
        } else {
            $searchConditions[] = ['like', 'orders.id', $this->search];
        }

        $query->andWhere(['or', ...$searchConditions]);
    }

    /**
     * Returns params of a filter as array string => value
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->params;
    }
}
