<?php

namespace orders\widgets;

use orders\helpers\OrderLabels;
use orders\models\OrderSearch;
use yii\grid\GridView;

/**
 * Widget for displaying orders
 */
class OrdersTable extends GridView
{

    private static OrderSearch $searchModel;

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
            'options' => [
                'tag' => false,
            ],
            'tableOptions' => [
                'class' => 'table order-table',
            ],
        ]);
    }

    /**
     * Returns an array for 'columns' GridView parameter
     *
     * @param array $servicesList
     * @return array[]
     */
    private static function getColumns(array $servicesList): array
    {
        return [
            [
                'attribute' => 'id',
                'label' => OrderLabels::getLabel('id'),
            ],
            [
                'label' => OrderLabels::getLabel('user'),
                'value' => function ($model) {
                    return $model->user->first_name . ' ' . $model->user->last_name;
                }
            ],
            [
                'attribute' => 'link',
                'label' => OrderLabels::getLabel('link'),
            ],
            [
                'attribute' => 'quantity',
                'label' => OrderLabels::getLabel('quantity'),
            ],
            [
                'attribute' => 'service_id',
                'header' => DropdownServiceRenderer::render($servicesList, self::$searchModel->search_id ?? ''),
                'headerOptions' => ['class' => 'dropdown-th'],
                'encodeLabel' => false,
                'value' => function ($model) {
                    return '<span class="label-id">' . $model->service->id . '</span> ' . $model->service->name;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'label' => OrderLabels::getLabel('status'),
                'value' => function ($model) {
                    return $model->getStatus();
                }
            ],
            [
                'attribute' => 'mode',
                'header' => DropdownModeRenderer::render(self::$searchModel, self::$searchModel->mode ?? ''),
                'headerOptions' => ['class' => 'dropdown-th'],
                'encodeLabel' => false,
                'value' => function ($model) {
                    return $model->getMode();
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => OrderLabels::getLabel('created_at'),
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
        ];
    }
}
