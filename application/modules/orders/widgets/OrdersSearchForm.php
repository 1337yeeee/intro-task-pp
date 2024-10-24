<?php

namespace orders\widgets;

use orders\models\OrderSearch;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Widget for search form
 */
class OrdersSearchForm extends Widget
{
    private static OrderSearch $searchModel;

    /**
     * @inheritDoc
     */
    public static function widget($config = []): string
    {
        self::$searchModel = $config['searchModel'];
        unset($config['searchModel']);
        return parent::widget($config);

    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        $action = Url::to(['', 'status' => self::$searchModel->getStatus()]);

        return $this->render('ordersSearchForm', [
            'action' => $action,
            'searchModel' => self::$searchModel,
        ]);
    }
}
