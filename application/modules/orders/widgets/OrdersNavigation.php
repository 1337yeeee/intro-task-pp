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
            'Pending' => Yii::t('app', 'Pending'),
            'In progress' => Yii::t('app', 'In progress'),
            'Completed' => Yii::t('app', 'Completed'),
            'Canceled' => Yii::t('app', 'Canceled'),
            'Error' => Yii::t('app', 'Error'),
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
        unset($params['service_id']);
        unset($params['status']);
        unset($params['mode']);

        if ($status) {
            return Url::to(array_merge(['/orders/' . $status], $params));
        } else {
            return Url::to(array_merge(['/orders'], $params));
        }
    }
}
