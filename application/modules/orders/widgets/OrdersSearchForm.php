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
        $status = self::$searchModel->getStatus();

        if ($status) {
            $status = '/' . $status;
        }

        ActiveForm::begin([
            'action' => ['/orders' . $status],
            'method' => 'get',
            'options' => ['class' => 'form-inline'],
        ]);

        echo '<div class="input-group">';

        echo Html::textInput('search', self::$searchModel->search, ['class' => 'form-control', 'placeholder' => self::$searchModel->getInputPlaceHolder()]);

        echo '<span class="input-group-btn search-select-wrap">';

        echo Html::dropDownList('search_type', self::$searchModel->search_type, self::$searchModel->getSearchTypes(), ['class' => 'form-control search-select']);

        echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-default']);

        echo '</span></div>';

        ActiveForm::end();
    }
}
