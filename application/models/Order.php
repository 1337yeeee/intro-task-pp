<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    public static function getRecentOrders(int $limit = 100, int $page = 1, $status = null, $service_id = null, $mode = null, $searchQuery = null): array
    {
        $offset = ($page - 1) * $limit;

        $query = self::find()
            ->joinWith(['user', 'service']) // Добавляем join для таблицы user
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit)
            ->offset($offset);

        if ($status !== null) {
            $query->andWhere(['status' => $status]);
        }

        if ($service_id !== null) {
            $query->andWhere(['service_id' => $service_id]);
        }

        if ($mode !== null) {
            $query->andWhere(['mode' => $mode]);
        }

        if ($searchQuery !== null) {
            $query->andWhere([
                'or',
                ['like', 'orders.id', $searchQuery],
                ['like', 'users.first_name', $searchQuery], // Теперь это работает
                ['like', 'users.last_name', $searchQuery],  // Это тоже работает
                ['like', 'orders.link', $searchQuery],
            ]);
        }

        return $query->asArray()->all();
    }


    public static function getCount($status = null, $service_id = null, $mode = null)
    {
        $query = self::find();

        if ($status !== null) {
            $query->andWhere(['status' => $status]);
        }

        if ($service_id !== null) {
            $query->andWhere(['service_id' => $service_id]);
        }

        if ($mode !== null) {
            $query->andWhere(['mode' => $mode]);
        }

        return $query->count();
    }

}
