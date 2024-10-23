<?php

namespace orders\widgets;

use Yii;
use yii\grid\GridView;
use yii\helpers\Url;

/**
 * Widget for displaying orders
 */
class OrdersTable extends GridView
{

    private static $searchModel;

    /**
     * @inheritDoc
     */
    public static function widget($config = []): string
    {
        $dataProvider = $config['dataProvider'];
        self::$searchModel = $config['searchModel'];

        $layoutPages = '<div class="row">
            <div class="col-sm-8">{pager}</div>
            <div class="col-sm-4 pagination-counters">{summary}</div>
        </div>';

        return parent::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{$layoutPages}",
            'columns' => self::getColumns($config['servicesList']),
        ]);
    }

    /**
     * Returns an array for 'columns' GridView parameter
     *
     * @param $servicesList
     * @return array[]
     */
    private static function getColumns($servicesList): array
    {
        return [
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
                'header' => DropdownServiceRenderer::render($servicesList, Yii::$app->request->get('service_id', '')),
//                'header' => self::renderDropdownService($servicesList),
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
                'filter' => self::$searchModel->getStatuses(),
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
        ];
    }

    /**
     * Renders drop down header for services
     *
     * @param $servicesList
     * @return string
     */
    private static function renderDropdownService($servicesList): string
    {
        $dropdownHtml = '<div class="dropdown">
            <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                ' . Yii::t('app', 'Service') . '
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';

        $currentServiceId = Yii::$app->request->get('service_id', '');

        $headRow = '';
        $rows = '';
        foreach ($servicesList as $service) {
            $active = $currentServiceId === (string)$service['id'] ? 'active' : '';
            $url = self::createUrlWithParam('service_id', (string)$service['id']);
            if ($service['name']) {
                $rows .= '<li><a ' . $active . ' href="' . $url . '"><span class="label-id">' . $service['order_count'] . '</span> ' . $service['name'] . '</a></li>';
            } else {
                $headRow = '<li class="' . $active . '"><a href="' . $url . '">' . Yii::t('app', 'All') . ' (' . $service['order_count'] . ')</a></li>';
            }
        }

        $dropdownHtml .= $headRow . $rows . '</ul></div>';

        return $dropdownHtml;
    }

    /**
     *  Renders drop down header for modes
     *
     * @return string
     */
    private static function renderDropdownMode(): string
    {
        $currentMode = Yii::$app->request->get('mode', '');

        $validModes = ['0' => 'Manual', '1' => 'Auto'];

        if (!array_key_exists($currentMode, $validModes)) {
            $currentMode = '';
        }

        $html = '<div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    ' . Yii::t('app', 'Mode') . '
                    <span class="caret"></span>
                </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';

        $modes = self::$searchModel->getModeModel()->getModes();

        foreach ($modes as $key => $mode) {
            $active = $currentMode === $key ? 'active' : '';
            $href = self::createUrlWithParam('mode', $key);
            $html .= <<<HTML
            <li class="{$active}">
                <a href="{$href}">{$mode}</a>
            </li>
            HTML;
        }

        $html .= '</ul></div>';

        return $html;
    }

    /**
     * Creates a URL with passed params
     *
     * @param $param
     * @param $value
     * @return string
     */
    private static function createUrlWithParam($param, $value): string
    {
        $params = Yii::$app->request->getQueryParams();

        if ($value === '') {
            unset($params[$param]);
        } else {
            $params[$param] = $value;
        }

        $params['page'] = 1;

        $status = $params['status'] ?? null;
        unset($params['status']);

        if ($status) {
            return Url::to(array_merge(['/orders/' . $status], $params));
        }

        return Url::to(array_merge(['/orders'], $params));
    }

}
