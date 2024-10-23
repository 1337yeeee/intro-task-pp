<?php

/** @var string $exportPath */

/** @var array $servicesList */

/** @var yii\data\ActiveDataProvider $dataProvider */

/** @var orders\models\OrderSearch $searchModel */

use orders\widgets\OrdersTable;
use orders\widgets\NavbarHeader;
use orders\widgets\OrdersNavigation;
use orders\widgets\DownloadButton;

?>

<?= NavbarHeader::widget() ?>

<div class="container-fluid">
    <?= OrdersNavigation::widget([
        'searchModel' => $searchModel,
    ]) ?>

    <?= OrdersTable::widget([
        'dataProvider' => $dataProvider,
        'servicesList' => $servicesList,
        'searchModel' => $searchModel,
    ]); ?>

    <?= DownloadButton::widget([
        'exportPath' => $exportPath,
    ]); ?>
</div>
