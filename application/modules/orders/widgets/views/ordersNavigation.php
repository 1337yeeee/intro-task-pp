<?php

/** @var array $statuses */

/** @var OrderSearch $searchModel */

use orders\models\OrderSearch;
use orders\widgets\OrdersSearchForm;

?>

<ul class="nav nav-tabs p-b" id="nav-tabs">
    <?php foreach ($statuses as $status => $label): ?>
        <li class="<?= $searchModel->getStatus() === $status ? 'active' : '' ?>">
            <a href="<?= $this->context->getUrl($status) ?>"><?= $label ?></a>
        </li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
        <?= OrdersSearchForm::widget([
            'searchModel' => $searchModel,
        ]) ?>
    </li>
</ul>
