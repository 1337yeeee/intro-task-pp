<?php

/** @var array $statuses */

/** @var OrderSearch $searchModel */

/** @var $currentStatus */

use orders\models\OrderSearch;
use orders\widgets\OrdersSearchForm;

?>

<ul class="nav nav-tabs p-b" id="nav-tabs">
    <?php foreach ($statuses as $status => $label): ?>
        <li class="<?= $currentStatus === $status ? 'active' : '' ?>">
            <a href="<?= $this->context->getUrl($status) ?>"><?= $label ?></a>
        </li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
        <?= OrdersSearchForm::widget([
            'searchModel' => $searchModel,
            'currentStatus' => $currentStatus,
        ]) ?>
    </li>
</ul>
