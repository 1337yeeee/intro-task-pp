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
    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->render('ordersNavigation', [
            'statuses' => $this->getStatuses(),
            'currentStatus' => Yii::$app->request->get('status', null),
        ]);
    }

    /**
     * Returns the available statuses for orders.
     */
    protected function getStatuses(): array
    {
        return [
            '' => Yii::t('app', 'All orders'),
            'pending' => Yii::t('app', 'Pending'),
            'inprogress' => Yii::t('app', 'In progress'),
            'completed' => Yii::t('app', 'Completed'),
            'canceled' => Yii::t('app', 'Canceled'),
            'error' => Yii::t('app', 'Error'),
        ];
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
