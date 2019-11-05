<?php

namespace micro\controllers\Actions;

use yii\base\Action;

/**
 * Базовый класс для всех API
 * @package micro\controllers\Actions
 */
class ApiAction extends Action
{
    /**
     * Перехват исключений для форматированного вывода ошибок
     * @param array $params
     * @return array|mixed
     */
    public function runWithParams($params)
    {
        try {
            return parent::runWithParams($params);
        } catch (\Exception $exception) {
            \Yii::$app->response->statusCode = 400;
            return [
                'name'  => get_class($exception),
                'message' => $exception->getMessage(),
                'code'   => $exception->getCode(),
                'status' => 400,
            ];
        }
    }
}
