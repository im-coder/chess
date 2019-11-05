<?php

namespace micro\controllers\Actions\Position;

use micro\controllers\Actions\ApiAction;
use micro\models\Games;
use yii\base\InvalidArgumentException;

/**
 * Обновление шахматной позиции
 */
class Update extends ApiAction
{
    /**
     * @param int $id Номер партии
     * @return int Номер партии при успешном обновлении
     * @throws \Throwable Сообщение об ошибке
     */
    public function run(int $id)
    {
        if (empty($positions = \Yii::$app->request->post('positions'))) {
            throw new InvalidArgumentException('Required argument "positions" not found');
        };

        Games::findModel($id)->updatePositions($positions);
        return $id;
    }
}
