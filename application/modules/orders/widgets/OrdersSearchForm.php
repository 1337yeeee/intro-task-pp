<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Widget for search form
 */
class OrdersSearchForm extends Widget
{
    public $search;
    public $searchType;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        // Установим значения по умолчанию, если их нет
        $this->search = $this->search ?? Yii::$app->request->get('search', '');
        $this->searchType = $this->searchType ?? Yii::$app->request->get('search_type', '0');
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
        $status = Yii::$app->request->get('status', '');
        if ($status) {
            $status = '/' . $status;
        }

        $form = ActiveForm::begin([
            'action' => ['/orders' . $status],
            'method' => 'get',
            'options' => ['class' => 'form-inline'],
        ]);

        echo '<div class="input-group">';

        echo Html::textInput('search', $this->search, ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Search orders')]);

        echo '<span class="input-group-btn search-select-wrap">';

        echo Html::dropDownList('search_type', $this->searchType, [
            '0' => Yii::t('app', 'Order ID'),
            '1' => Yii::t('app', 'Link'),
            '2' => Yii::t('app', 'Username'),
        ], ['class' => 'form-control search-select']);

        echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-default']);

        echo '</span></div>';

        ActiveForm::end();
    }
}
