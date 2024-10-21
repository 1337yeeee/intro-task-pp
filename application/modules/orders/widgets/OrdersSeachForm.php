<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class OrdersSeachForm extends Widget
{
    public $search;
    public $searchType;

    public function init()
    {
        parent::init();
        // Установим значения по умолчанию, если их нет
        $this->search = $this->search ?? Yii::$app->request->get('search', '');
        $this->searchType = $this->searchType ?? Yii::$app->request->get('search_type', '0');
    }

    public function run()
    {
        ob_start();
        $this->renderForm();
        return ob_get_clean();
    }

    private function renderForm()
    {
        $form = ActiveForm::begin([
            'action' => ['/orders'], // Можно сделать параметризуемым
            'method' => 'get',
            'options' => ['class' => 'form-inline'],
        ]);

        echo '<div class="input-group">';

        // Поле поиска
        echo Html::textInput('search', $this->search, ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Search orders')]);

        echo '<span class="input-group-btn search-select-wrap">';

        // Выпадающий список для выбора типа поиска
        echo Html::dropDownList('search_type', $this->searchType, [
            '0' => Yii::t('app', 'Order ID'),
            '1' => Yii::t('app', 'Link'),
            '2' => Yii::t('app', 'Username'),
        ], ['class' => 'form-control search-select']);

        // Кнопка поиска
        echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-default']);

        echo '</span></div>';

        ActiveForm::end();
    }
}
