<?php

namespace orders\widgets;

use orders\helpers\OrderLabels;
use yii\base\Widget;

/**
 * Renders navigation bar
 */
class NavbarHeader extends Widget
{

    public const NAME = 'orders';

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->renderNav();
    }

    /**
     * Renders navigation tabs
     *
     * @return string
     */
    private function renderNav(): string
    {
        return '
        <nav class="navbar navbar-fixed-top navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">' . OrderLabels::getLabel(self::NAME) . '</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        ';

    }
}
