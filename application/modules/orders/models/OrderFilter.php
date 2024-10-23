<?php

namespace orders\models;

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
    private bool $doJoin = true;

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
     * If `false` tables won't be joined in `applyFilters` method
     *
     * @param bool $doJoin
     * @return void
     */
    public function setDoJoin(bool $doJoin = true)
    {
        $this->doJoin = $doJoin;
    }

    /**
     * Applies filters on the query
     *
     * @param $query
     * @return void
     */
    public function applyFilters($query)
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
     * @param $query
     * @return void
     */
    protected function applySearch($query)
    {
        if ($this->doJoin) {
            $query->joinWith(['user', 'service']);
        }

        $searchConditions = [];
        if ($this->search_type === '1') {
            $searchConditions[] = ['like', 'orders.link', $this->search];
        } elseif ($this->search_type === '2') {
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
