<?php

namespace orders\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * User active record
 */
class User extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'users';
    }
}
