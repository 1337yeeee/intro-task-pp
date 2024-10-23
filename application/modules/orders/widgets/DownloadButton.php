<?php

namespace orders\widgets;

use Yii;
use yii\base\Widget;

class DownloadButton extends Widget
{
    public $exportPath;
    public $buttonText;

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
        if (!isset($this->buttonText)) {
            $this->buttonText = Yii::t('app', 'Download');
        }
        return '
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="' . ($this->exportPath ?? '#') . '" class="btn btn-primary">
                        ' . $this->buttonText . '
                    </a>
                </div>
            </div>
        ';
    }
}
