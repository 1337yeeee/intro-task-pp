<?php

namespace orders\widgets;

use Yii;
use yii\base\Widget;

class DownloadButton extends Widget
{
    public $exportPath;
    public const BUTTON_TEXT = 'Download';

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function run(): string
    {
        return $this->renderButton();
    }

    /**
     * Generates the HTML for the button.
     *
     * @return string
     */
    protected function renderButton(): string
    {
        return '
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="' . ($this->exportPath ?? '#') . '" class="btn btn-primary">
                        ' . Yii::t('app', self::BUTTON_TEXT) . '
                    </a>
                </div>
            </div>
        ';
    }
}
