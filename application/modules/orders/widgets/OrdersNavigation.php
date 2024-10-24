<?php

namespace orders\widgets;

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
            'currentStatus' => Yii::$app->request->get('status', ''),
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
