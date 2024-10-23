<?php

namespace orders\widgets;

use orders\helpers\UrlHelper;
use Yii;

/**
 * Renders drop down list of available modes
 */
class DropdownModeRenderer
{

    /**
     * Renders drop down list of available modes
     *
     * @param $searchModel
     * @param $currentMode
     * @return string
     */
    public static function render($searchModel, $currentMode): string
    {
        $validModes = ['0' => 'Manual', '1' => 'Auto'];

        if (!array_key_exists($currentMode, $validModes)) {
            $currentMode = '';
        }

        $html = '<div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    ' . Yii::t('app', 'Mode') . '
                    <span class="caret"></span>
                </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';

        $modes = $searchModel->getModeModel()->getModes();

        foreach ($modes as $key => $mode) {
            $active = $currentMode === $key ? 'active' : '';
            $href = UrlHelper::createUrlWithParam('mode', $key);
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
