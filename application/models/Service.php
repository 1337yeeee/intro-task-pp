<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    public static function tableName()
    {
        return 'services';
    }
}
