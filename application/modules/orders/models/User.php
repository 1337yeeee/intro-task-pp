<?php

namespace orders\models;

use yii\db\ActiveRecord;

/**
 * User active record
 */
class User extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'users';
    }
}
