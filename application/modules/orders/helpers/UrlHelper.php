<?php

namespace orders\helpers;

use Yii;
use yii\helpers\Url;

/**
 * Contains method to create a URL with passed parameter
 */
class UrlHelper
{
    /**
     * Returns an url with params to orders page
     *
     * @param $param string a parameter to be set
     * @param $value mixed value of the parameter
     * @return string
     */
    public static function createUrlWithParam($param, $value): string
    {
        $params = Yii::$app->request->getQueryParams();

        if ($value === '') {
            unset($params[$param]);
        } else {
            $params[$param] = $value;
        }

        $params['page'] = 1;

        $status = $params['status'] ?? null;
        unset($params['status']);

        if ($status) {
            return Url::to(array_merge(['/orders/' . $status], $params));
        }

        return Url::to(array_merge(['/orders'], $params));
    }
}
