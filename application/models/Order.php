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

    public static function getRecentOrders($limit = 100, $status = null, $service_id = null, $mode = null, int $page=1): array
    {
        $offset = ($page - 1) * $limit;

        $query = self::find()
            ->with(['user', 'service'])
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
