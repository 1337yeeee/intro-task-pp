<?php

namespace orders\models;

use Yii;
use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    public const ALL_SERVICES_LABEL = 'All';

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * Return a label for rolled up values of services (as a sum of them)
     *
     * @return string
     */
    public static function getAllServicesLabel(): string
    {
        return Yii::t('app', self::ALL_SERVICES_LABEL);
    }
}
