<?php

namespace app\modules\orders\models;

class OrderFilter
{
    public $status;
    public $service_id;
    public $mode;
    public $searchQuery;
    public $searchColumn;

    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

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

    protected function applySearch($query)
    {
        $query->joinWith(['user', 'service']);

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
}
