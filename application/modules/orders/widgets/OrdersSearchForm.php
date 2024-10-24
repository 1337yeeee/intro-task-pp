<?php

namespace orders\widgets;

use orders\models\OrderSearch;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
        $status = self::$searchModel->getStatus();

        if ($status) {
            $status = '/' . $status;
        }
        return $this->render('ordersSearchForm', [
            'status' => $status,
            'searchModel' => self::$searchModel,
        ]);
    }
}
