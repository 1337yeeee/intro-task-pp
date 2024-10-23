<?php

namespace orders\models;

use Yii;
use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'services';
    }
}
