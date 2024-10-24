<?php

/** @var OrderSearch $searchModel */

/** @var string $action */

use orders\models\OrderSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => [$action],
    'method' => 'get',
    'options' => ['class' => 'form-inline'],
]); ?>

<div class="input-group">
    <?= Html::textInput('search', $searchModel->search, ['class' => 'form-control', 'placeholder' => $searchModel->getInputPlaceHolder()]); ?>
    <span class="input-group-btn search-select-wrap">'
        <?= Html::dropDownList('search_type', $searchModel->search_type, $searchModel->getSearchTypes(), ['class' => 'form-control search-select']); ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-default']); ?>
    </span>
</div>

<?php ActiveForm::end(); ?>
