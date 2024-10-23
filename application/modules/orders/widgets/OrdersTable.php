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
     * @param $servicesList
     * @return array[]
     */
    private static function getColumns($servicesList): array
    {
        return [
            [
                'attribute' => 'id',
                'label' => Yii::t('app', self::$searchModel::ID_LABEL),
            ],
            [
                'label' => Yii::t('app', self::$searchModel::USER_LABEL),
                'value' => function ($model) {
                    return $model->user->first_name . ' ' . $model->user->last_name;
                }
            ],
            [
                'attribute' => 'link',
                'label' => Yii::t('app', self::$searchModel::LINK_LABEL),
            ],
            [
                'attribute' => 'quantity',
                'label' => Yii::t('app', self::$searchModel::QUANTITY_LABEL),
            ],
            [
                'attribute' => 'service_id',
                'header' => DropdownServiceRenderer::render($servicesList, Yii::$app->request->get('service_id', '')),
                'headerOptions' => ['class' => 'dropdown-th'],
                'encodeLabel' => false,
                'value' => function ($model) {
                    return '<span class="label-id">' . $model->service->id . '</span> ' . $model->service->name;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'label' => Yii::t('app', self::$searchModel::STATUS_LABEL),
                'value' => function ($model) {
                    return $model->getStatus();
                }
            ],
            [
                'attribute' => 'mode',
                'header' => DropdownModeRenderer::render(self::$searchModel, Yii::$app->request->get('mode')),
                'headerOptions' => ['class' => 'dropdown-th'],
                'encodeLabel' => false,
                'value' => function ($model) {
                    return $model->getMode();
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => Yii::t('app', self::$searchModel::CREATED_AT_LABEL),
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
        ];
    }
}
