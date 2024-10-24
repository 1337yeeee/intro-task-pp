<?php

namespace orders\widgets;

use orders\helpers\OrderLabels;
use orders\models\OrderSearch;
use yii\helpers\Url;

/**
 * Renders drop down list of available modes
 */
class DropdownModeRenderer
{

    public const FIELD = 'mode';

    /**
     * Renders drop down list of available modes
     *
     * @param OrderSearch $searchModel
     * @param string $currentMode
     * @return string
     */
    public static function render(OrderSearch $searchModel, string $currentMode): string
    {
        $html = '<div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    ' . OrderLabels::getLabel(self::FIELD) . '
                    <span class="caret"></span>
                </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';

        $modes = $searchModel->getModes();

        foreach ($modes as $key => $mode) {
            $active = $currentMode === $key ? 'active' : '';
            $href = Url::current(['mode' => $key]);
            $html .= <<<HTML
            <li class="{$active}">
                <a href="{$href}">{$mode}</a>
            </li>
            HTML;
        }

        $html .= '</ul></div>';

        return $html;
    }

}
