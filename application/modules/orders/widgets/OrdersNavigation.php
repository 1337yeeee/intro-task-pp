<?php

namespace orders\widgets;

use orders\models\OrderSearch;
use orders\models\Status;
use yii\base\Widget;

/**
 * Widget for rendering orders navigation tabs.
 */
class OrdersNavigation extends Widget
{

    public OrderSearch $searchModel;

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->render('ordersNavigation', [
            'statuses' => Status::getStatusesWithKeys(),
            'searchModel' => $this->searchModel,
        ]);
    }
}
