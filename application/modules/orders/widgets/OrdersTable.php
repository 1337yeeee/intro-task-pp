<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * Widget for displaying orders
 */
class OrdersTable extends GridView
{
    public static function widget($config = []): string
    {
        $dataProvider = clone $config['dataProvider'];
        $dataProvider->pagination = false;

        return parent::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'id',
                    'label' => Yii::t('app', 'ID'),
                ],
                [
                    'label' => Yii::t('app', 'User'),
                    'value' => function ($model) {
                        return $model->user->first_name . ' ' . $model->user->last_name;
                    }
                ],
                [
                    'attribute' => 'link',
                    'label' => Yii::t('app', 'Link'),
                ],
                [
                    'attribute' => 'quantity',
                    'label' => Yii::t('app', 'Quantity'),
                ],
                [
                    'attribute' => 'service_id',
                    'header' => self::renderDropdownService($config['servicesList']),
                    'headerOptions' => ['class' => 'dropdown-th'],
                    'encodeLabel' => false,
                    'value' => function ($model) {
                        return '<span class="label-id">' . $model->service->id . '</span> ' . $model->service->name;
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'status',
                    'label' => Yii::t('app', 'Status'),
                    'filter' => [
                        'Pending' => Yii::t('app', 'Pending'),
                        'In progress' => Yii::t('app', 'In progress'),
                        'Completed' => Yii::t('app', 'Completed'),
                        'Canceled' => Yii::t('app', 'Canceled'),
                        'Error' => Yii::t('app', 'Error'),
                    ],
                    'value' => function ($model) {
                        return $model->getStatus();
                    }
                ],
                [
                    'attribute' => 'mode',
                    'header' => self::renderDropdownMode(),
                    'headerOptions' => ['class' => 'dropdown-th'],
                    'encodeLabel' => false,
                    'value' => function ($model) {
                        return $model->getMode();
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'label' => Yii::t('app', 'Created'),
                    'format' => ['date', 'php:Y-m-d H:i:s'],
                ],
            ],
        ]);
    }

    private static function renderDropdownService($servicesList)
    {
        $dropdownHtml = '<div class="dropdown">
            <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                ' . Yii::t('app', 'Service') . '
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';

        $currentMode = Yii::$app->request->get('service_id', '');

        // Добавляем элемент "All"
        $dropdownHtml .= '<li class="' . ($currentMode === '' ? 'active' : '') . '"><a href="' . self::createUrlWithParam('service_id', '') . '">' . Yii::t('app', 'All') . ' (894931)</a></li>';

        // Добавляем остальные сервисы
        foreach ($servicesList as $service) {
            $dropdownHtml .= '<li><a ' . ($currentMode === (string)$service['id'] ? 'active' : '') . ' href="' . self::createUrlWithParam('service_id', $service['id']) . '"><span class="label-id">' . $service['order_count'] . '</span> ' . $service['name'] . '</a></li>';
        }

        $dropdownHtml .= '</ul></div>';

        return $dropdownHtml;
    }

    private static function renderDropdownMode(): string
    {
        $currentMode = Yii::$app->request->get('mode', '');

        $validModes = ['0' => 'Manual', '1' => 'Auto'];

        if (!array_key_exists($currentMode, $validModes)) {
            $currentMode = '';
        }

        return '
            <div class="dropdown">
              <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                ' . Yii::t('app', 'Mode') . '
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li class="' . ($currentMode === '' ? 'active' : '') . '">
                    <a href="' . self::createUrlWithParam('mode', '') . '">' . Yii::t('app', 'All') . '</a>
                </li>
                <li class="' . ($currentMode === '0' ? 'active' : '') . '">
                    <a href="' . self::createUrlWithParam('mode', '0') . '">' . Yii::t('app', 'Manual') . '</a>
                </li>
                <li class="' . ($currentMode === '1' ? 'active' : '') . '">
                    <a href="' . self::createUrlWithParam('mode', '1') . '">' . Yii::t('app', 'Auto') . '</a>
                </li>
              </ul>
            </div>';
    }

    private static function createUrlWithParam($param, $value): string
    {
        $params = Yii::$app->request->getQueryParams();

        if ($value === '') {
            unset($params[$param]);
        } else {
            $params[$param] = $value;
        }

        return Yii::$app->urlManager->createUrl(['orders'] + $params);
    }

}
