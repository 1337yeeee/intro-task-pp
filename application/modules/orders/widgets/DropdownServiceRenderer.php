<?php

namespace orders\widgets;

use orders\helpers\OrderLabels;
use orders\models\Service;
use yii\helpers\Url;

/**
 * Renders drop down list of available services
 */
class DropdownServiceRenderer
{

    public const FIELD = 'service';
    public const ALL_SERVICES = 'All';

    /**
     * Renders drop down list of available services
     *
     * @param array $servicesList
     * @param string $currentServiceId
     * @return string
     */
    public static function render(array $servicesList, string $currentServiceId): string
    {
        $dropdownHtml = '<div class="dropdown">
            <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                ' . OrderLabels::getLabel(self::FIELD) . '
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';

        $headRow = '';
        $rows = '';
        foreach ($servicesList as $service) {
            $active = $currentServiceId === (string)$service['id'] ? 'active' : '';
            $url = Url::current(['service_id' => $service['id']]);
            if ($service['name']) {
                $rows .= '<li><a ' . $active . ' href="' . $url . '"><span class="label-id">' . $service['order_count'] . '</span> ' . $service['name'] . '</a></li>';
            } else {
                $headRow = '<li class="' . $active . '"><a href="' . $url . '">' . Service::getAllServicesLabel() . ' (' . $service['order_count'] . ')</a></li>';
            }
        }

        $dropdownHtml .= $headRow . $rows . '</ul></div>';

        return $dropdownHtml;
    }
}

