<?php

/** @var array $services */
/** @var array $servicesList */
/** @var yii\data\ActiveDataProvider $dataProvider */

/** @var app\modules\orders\models\Order $searchModel */

use app\modules\orders\widgets\OrdersTable;
use app\modules\orders\widgets\OrdersSeachForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <style>
        .label-default {
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#"><?= Yii::t('app', 'Orders') ?></a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <ul class="nav nav-tabs p-b" id="nav-tabs">
        <li data-type="status" data-status="" class="active"><a href="#"><?= Yii::t('app', 'All orders') ?></a></li>
        <li data-type="status" data-status="Pending"><a href="#"><?= Yii::t('app', 'Pending') ?></a></li>
        <li data-type="status" data-status="In progress"><a href="#"><?= Yii::t('app', 'In progress') ?></a></li>
        <li data-type="status" data-status="Completed"><a href="#"><?= Yii::t('app', 'Completed') ?></a></li>
        <li data-type="status" data-status="Canceled"><a href="#"><?= Yii::t('app', 'Canceled') ?></a></li>
        <li data-type="status" data-status="Error"><a href="#"><?= Yii::t('app', 'Error') ?></a></li>
        <li class="pull-right custom-search">
            <?= OrdersSeachForm::widget() ?>
        </li>
    </ul>
    <?= OrdersTable::widget([
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'servicesList' => $servicesList,
    ]); ?>
    <div class="row">
        <div class="col-sm-8">
            <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
        <div class="col-sm-4 pagination-counters">
            <?= Yii::t('app', 'Показаны записи {start}-{end} из {total}', [
                'start' => $dataProvider->pagination->offset + 1,
                'end' => min($dataProvider->pagination->offset + $dataProvider->pagination->limit, $dataProvider->totalCount),
                'total' => $dataProvider->totalCount
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4 pagination-counters">
            <button class="btn btn-th btn-primary" id="export-btn" type="button">
                <?= Yii::t('app', 'Download') ?>
            </button>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/orders.js?<?php echo random_int(0, 2 ** 15) ?>"></script>
</body>
<html>
