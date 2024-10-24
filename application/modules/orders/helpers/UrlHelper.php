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
    public static function createUrlWithParam(string $param, $value): string
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

    /**
     * Generates URL with the given status and saves search statement.
     *
     * @param string|null $status
     * @return string
     */
    public static function getUrlWithStatusAndSearchOnly(?string $status = null): string
    {
        $params = Yii::$app->request->queryParams;

        $newParams = [];

        if (isset($params['search'])) {
            $newParams['search'] = $params['search'];
        }
        if (isset($params['search_type'])) {
            $newParams['search_type'] = $params['search_type'];
        }

        if ($status) {
            return Url::to(array_merge(['/orders/' . $status], $newParams));
        } else {
            return Url::to(array_merge(['/orders'], $newParams));
        }
    }
}
