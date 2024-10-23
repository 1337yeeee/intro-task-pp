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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
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

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
<html>
