<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class OrdersNavigation extends Widget
{
    /**
     * Renders the widget.
     *
     * @return string
     * @throws \Throwable
     */
    public function run(): string
    {
        return $this->renderTabs();
    }

    /**
     * Renders the order status tabs.
     *
     * @return string The HTML for the tabs
     * @throws \Throwable
     */
    protected function renderTabs(): string
    {
        $currentStatus = Yii::$app->request->get('status', null);

        $statuses = [
            '' => Yii::t('app', 'All orders'),
            'pending' => Yii::t('app', 'Pending'),
            'inprogress' => Yii::t('app', 'In progress'),
            'completed' => Yii::t('app', 'Completed'),
            'canceled' => Yii::t('app', 'Canceled'),
            'error' => Yii::t('app', 'Error'),
        ];

        $html = '<ul class="nav nav-tabs p-b" id="nav-tabs">';

        foreach ($statuses as $status => $label) {
            $activeClass = ($currentStatus === $status) ? 'active' : '';
            $html .= '<li data-type="status" data-status="' . $status . '" class="' . $activeClass . '">';
            $html .= '<a href="' . $this->getUrl($status) . '">' . $label . '</a>';
            $html .= '</li>';
        }

        $html .= '<li class="pull-right custom-search">' . OrdersSearchForm::widget() . '</li>';
        $html .= '</ul>';

        return $html;
    }

    /**
     * Creates a URL to orders/<status>
     *
     * @param string|null $status
     * @return string
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
