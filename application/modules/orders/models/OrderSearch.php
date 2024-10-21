<?php

namespace app\modules\orders\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveRecord;

/**
 * Decorator for Order model for applying filters
 */
class OrderSearch extends Order
{
    public string $search = '';
    public int $search_type = 0;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['search'], 'safe'],
            [['$search_type'], 'integer'],
        ];
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
     * @param Pagination $pagination
     * @param OrderFilter|null $filter
     * @return ActiveDataProvider
     */
    public function search(Pagination $pagination, ?OrderFilter $filter = null): ActiveDataProvider
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

        if ($filter !== null) {
            $filter->applyFilters($query);
        }

        return $dataProvider;
    }

    /**
     * Returns the list of services and their quantities given the filters
     *
     * @param OrderFilter|null $filter
     * @return array|ActiveRecord[]
     */
    public static function getServicesOfOrders(?OrderFilter $filter = null)
    {
        $query = self::find()
            ->joinWith('service')
            ->select(['services.name', 'services.id', 'COUNT(orders.id) as order_count'])
            ->groupBy(['services.name', 'services.id'])
            ->orderBy(['order_count' => SORT_DESC]);

        $filter->applyFilters($query);

        return $query->asArray()->all();
    }

    /**
     * Get count of filtered orders
     *
     * @param OrderFilter|null $filter
     * @return bool|int|string|null
     */
    public static function getCount(?OrderFilter $filter = null)
    {
        $query = self::find();

        if ($filter !== null) $filter->applyFilters($query);

        return $query->count();
    }

    /**
     * Iterate through orders applying batch size
     *
     * @param int $batchSize
     * @param OrderFilter|null $filter
     * @return \Generator
     */
    public function getRecentOrdersBatch(int $batchSize = 100, ?OrderFilter $filter = null): \Generator
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

        if ($filter !== null) {
            $filter->applyFilters($query);
        }

        foreach ($query->batch($batchSize) as $ordersBatch) {
            yield $ordersBatch;
        }
    }
}
