<?php

namespace orders\widgets;

use orders\helpers\UrlHelper;
use orders\models\OrderSearch;
use orders\models\Status;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;

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

    /**
     * Generates URL with the given status.
     *
     * @param string|null $status
     * @return string
     */
    public function getUrl(?string $status = null): string
    {
        return UrlHelper::getUrlWithStatusAndSearchOnly($status);
    }
}
