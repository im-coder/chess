<?php

namespace micro\controllers\Actions\Position;

use micro\controllers\Actions\ApiAction;
use micro\models\Games;
use yii\base\InvalidArgumentException;

/**
 * Создание щахматной позиции
 */
class Create extends ApiAction
{
    /**
     * @return int Номер партии
     * @throws \Exception Сообщение об ошибке
     */
    public function run()
    {
        if (empty($positions = \Yii::$app->request->post('positions'))) {
            throw new InvalidArgumentException('Required argument "positions" not found');
        };
        $name = \Yii::$app->request->post('name');
        return Games::newGameWithPositions($positions, $name)->id;
    }
}
