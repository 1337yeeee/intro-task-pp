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

    public static function getRecentOrders($limit = 100)
    {
        return self::find()
            ->with(['user', 'service'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit)
            ->asArray()
            ->all();
    }
}
