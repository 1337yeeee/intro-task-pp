<?php

namespace app\controllers;

use yii\web\Controller;

class OrdersController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index'); // Загружаем представление 'index.php'
    }
}
