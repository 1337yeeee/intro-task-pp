<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;

/**
 * Renders navigation bar
 */
class NavbarHeader extends Widget
{
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
                        <li class="active"><a href="#">' . Yii::t('app', 'Orders') . '</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        ';

    }
}
