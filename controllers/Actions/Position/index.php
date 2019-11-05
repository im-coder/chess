<?php

namespace micro\controllers\Actions\Position;

use micro\controllers\Actions\ApiAction;
use micro\models\Games;

/**
 * Получение игровой партии по номеру
 */
class Index extends ApiAction
{
    /**
     * @param int $id
     * @return array
     */
    public function run(int $id)
    {
        return Games::findModel($id)->getGameWithPositions();
    }
}
