<?php

namespace orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Widget for rendering orders navigation tabs.
 */
class OrdersNavigation extends Widget
{

    public $searchModel;

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->render('ordersNavigation', [
            'statuses' => $this->searchModel->getStatusModel()->getStatuses(),
            'currentStatus' => Yii::$app->request->get('status', ''),
        ]);
    }

    /**
     * Generates URL with the given status.
     */
    public function getUrl(?string $status = null): string
    {
        $params = Yii::$app->request->queryParams;

        $newParams = [];

        if (isset($params['search'])) {
            $newParams['search'] = $params['search'];
        }
        if (isset($params['search_type'])) {
            $newParams['search_type'] = $params['search_type'];
        }

        if ($status) {
            return Url::to(array_merge(['/orders/' . $status], $newParams));
        } else {
            return Url::to(array_merge(['/orders'], $newParams));
        }
    }
}
