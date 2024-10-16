
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
        .label-default{
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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
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
        <li data-type="status" data-status="" class="active"><a href="#"><?= Yii::t('app', 'All orders')?></a></li>
        <li data-type="status" data-status="Pending"><a href="#"><?= Yii::t('app', 'Pending') ?></a></li>
        <li data-type="status" data-status="In progress"><a href="#"><?= Yii::t('app', 'In progress') ?></a></li>
        <li data-type="status" data-status="Completed"><a href="#"><?= Yii::t('app', 'Completed') ?></a></li>
        <li data-type="status" data-status="Canceled"><a href="#"><?= Yii::t('app', 'Canceled') ?></a></li>
        <li data-type="status" data-status="Error"><a href="#"><?= Yii::t('app', 'Error') ?></a></li>
        <li class="pull-right custom-search">
            <form class="form-inline" action="/orders" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="" placeholder="<?= Yii::t('app', 'Search orders') ?>" id="search-input">
                    <span class="input-group-btn search-select-wrap">

                    <select class="form-control search-select" name="search-type" id="search-type">
                      <option value="1" selected=""><?= Yii::t('app', 'Order ID') ?></option>
                      <option value="2"><?= Yii::t('app', 'Link') ?></option>
                      <option value="3"><?= Yii::t('app', 'Username') ?></option>
                    </select>
                    <button type="submit" class="btn btn-default" id="search-button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
            </form>
        </li>
    </ul>
    <table class="table order-table" id="orders-table">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'ID') ?></th>
            <th><?= Yii::t('app', 'User') ?></th>
            <th><?= Yii::t('app', 'Link') ?></th>
            <th><?= Yii::t('app', 'Quantity') ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('app', 'Service')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" id="services-data">
                    </ul>
                </div>
            </th>
            <th><?= Yii::t('app', 'Status') ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('app', 'Mode') ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" id="mode-list">
                        <li data-mode="" class="active"><a href=""><?= Yii::t('app', 'All') ?></a></li>
                        <li data-mode="0"><a href=""><?= Yii::t('app', 'Manual') ?></a></li>
                        <li data-mode="1"><a href=""><?= Yii::t('app', 'Auto') ?></a></li>
                    </ul>
                </div>
            </th>
            <th><?= Yii::t('app', 'Created') ?></th>
        </tr>
        </thead>
        <tbody id="orders-table">
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">

            <nav>
                <ul class="pagination" id="pagination">
                    <li class="disabled"><a href="" aria-label="Previous">&laquo;</a></li>
                    <li class="active"><a href="">1</a></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                    <li><a href="">5</a></li>
                    <li><a href="">6</a></li>
                    <li><a href="">7</a></li>
                    <li><a href="">8</a></li>
                    <li><a href="">9</a></li>
                    <li><a href="">10</a></li>
                    <li><a href="" aria-label="Next">&raquo;</a></li>
                </ul>
            </nav>

        </div>
        <div class="col-sm-4 pagination-counters" id="pagination-counters">
        </div>

    </div>
</div>

<script>
    const translations = {
        'Pending': '<?= Yii::t('app', 'Pending') ?>',
        'In progress': '<?= Yii::t('app', 'In progress') ?>',
        'Completed': '<?= Yii::t('app', 'Completed') ?>',
        'Canceled': '<?= Yii::t('app', 'Canceled') ?>',
        'Error': '<?= Yii::t('app', 'Error') ?>',
        'Manual': '<?= Yii::t('app', 'Manual') ?>',
        'Auto': '<?= Yii::t('app', 'Auto') ?>'
    };
</script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/orders.js?<?php echo random_int(0,2**15)?>"></script>
</body>
<html>
