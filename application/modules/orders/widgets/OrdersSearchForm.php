<?php

namespace orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Widget for search form
 */
class OrdersSearchForm extends Widget
{
    private static $searchModel;
    private static $currentStatus;

    public const TEXT_INPUT_PLACEHOLDER = 'Search orders';

    public static function widget($config = [])
    {
        self::$searchModel = $config['searchModel'];
        self::$currentStatus = $config['currentStatus'];
        unset($config['searchModel']);
        unset($config['currentStatus']);
        return parent::widget($config);

    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        ob_start();
        $this->renderForm();
        return ob_get_clean();
    }

    /**
     * Renders the form with input fields
     *
     * @return void
     */
    private function renderForm()
    {
        $status = self::$currentStatus;
        if ($status) {
            $status = '/' . $status;
        }

        ActiveForm::begin([
            'action' => ['/orders' . $status],
            'method' => 'get',
            'options' => ['class' => 'form-inline'],
        ]);

        echo '<div class="input-group">';

        echo Html::textInput('search', self::$searchModel->search, ['class' => 'form-control', 'placeholder' => Yii::t('app', self::TEXT_INPUT_PLACEHOLDER)]);

        echo '<span class="input-group-btn search-select-wrap">';

        echo Html::dropDownList('search_type', self::$searchModel->search_type, self::$searchModel->getSearchTypes(), ['class' => 'form-control search-select']);

        echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-default']);

        echo '</span></div>';

        ActiveForm::end();
    }
}
