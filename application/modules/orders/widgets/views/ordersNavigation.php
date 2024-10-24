<?php

/** @var array $statuses */

/** @var OrderSearch $searchModel */

use orders\models\OrderSearch;
use orders\widgets\OrdersSearchForm;
use yii\helpers\Url;

?>

<ul class="nav nav-tabs p-b" id="nav-tabs">
    <?php $search = $searchModel->search; ?>
    <?php $search_type = $searchModel->search_type; ?>

    <?php foreach ($statuses as $status => $label): ?>
        <li class="<?= $searchModel->getStatus() === $status ? 'active' : '' ?>">
            <a href="<?= Url::to(['', 'status' => $status, 'search' => $search, 'search_type' => $search_type]) ?>"><?= $label ?></a>
        </li>
    <?php endforeach; ?>

    <li class="pull-right custom-search">
        <?= OrdersSearchForm::widget([
            'searchModel' => $searchModel,
        ]) ?>
    </li>
</ul>
