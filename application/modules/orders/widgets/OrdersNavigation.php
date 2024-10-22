<?php

namespace app\modules\orders\widgets;

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
            'statuses' => $this->searchModel->getStatuses(),
            'currentStatus' => Yii::$app->request->get('status', null),
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
            $newParams['search'] = $params['search'] ?? null;
        }
        if (isset($params['status'])) {
            $newParams['search_type'] = $params['search_type'] ?? null;
        }

        if ($status) {
            return Url::to(array_merge(['/orders/' . $status], $newParams));
        } else {
            return Url::to(array_merge(['/orders'], $newParams));
        }
    }
}
