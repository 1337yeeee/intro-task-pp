<?php

namespace app\modules\orders\models;

/**
 * Class for applying filters on query which works with orders
 */
class OrderFilter
{
    private $params;
    public $status;
    public $service_id;
    public $mode;
    public $searchQuery;
    public $searchColumn;
    private bool $doJoin = false;

    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
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
        if ($this->searchQuery !== null) {
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
        if ($this->searchColumn === 'link') {
            $searchConditions[] = ['like', 'orders.link', $this->searchQuery];
        } elseif ($this->searchColumn === 'users') {
            $searchConditions[] = ['like', 'users.first_name', $this->searchQuery];
            $searchConditions[] = ['like', 'users.last_name', $this->searchQuery];
        } else {
            $searchConditions[] = ['like', 'orders.id', $this->searchQuery];
        }

        $query->andWhere(['or', ...$searchConditions]);
    }

    public function toArray()
    {
        return $this->params;
    }
}
