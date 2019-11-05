<?php

namespace micro\models;

use function array_map;
use yii\base\InvalidArgumentException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Шахматные партии
 * @package micro\models
 *
 * @property int $id
 * @property string $name
 *
 * @property Positions[] $positions
 */
class Games extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'games';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['id', 'integer'],
            ['name', 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id'   => 'Номер партии',
            'name' => 'Название партии',
        ];
    }

    /**
     * Свзяь с моделью шахматных игровых позиций
     * @return ActiveQuery
     */
    public function getPositions(): ActiveQuery
    {
        return $this->hasMany(Positions::class, ['game_id' => 'id']);
    }

    /**
     * Поиск модели по ее названию
     * @param int $id
     * @return Games|null
     */
    public static function findModel(int $id): ?self
    {
        $model = self::findOne(['id' => $id]);
        if ($model === null) {
            throw new InvalidArgumentException('Game not found');
        }

        return $model;
    }

    /**
     * Получает данные шахматной партии вместе с позициями шахматных фигур
     * @return array
     */
    public function getGameWithPositions()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'positions' => array_map(function($position) {
                return $position->getAttributes(['board','figure','color']);
            }, $this->positions),
        ];
    }

    /**
     * Создание новой шахматной партии с добавлением шахматных позиций
     * Если во время проверки произойдет ошибка, то все записи будут отменены
     * @param array $positions Список щахматных позиций
     * @param string|null $nameGame Название шахматной партии
     * @return Games
     * @throws \Exception
     */
    public static function newGameWithPositions(array $positions, string $nameGame = null): self
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $game = new self(['name' => $nameGame]);
            $game->save();
            $game->addPositions($positions);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $game;
    }

    /**
     * Добавление шахматных позиций в текущую партию
     * @param array $newPositions
     */
    public function addPositions(array $newPositions)
    {
        foreach ($newPositions as $newPosition) {
            $position = new Positions($newPosition);
            $position->game_id = $this->id;
            if ($position->validate() === false) {
                throw new InvalidArgumentException(implode('; ', array_map(function ($error) {
                    return implode(' ', $error);
                }, $position->errors)));
            }
            $position->save();
        }
    }

    /**
     * Обновление шахматных позиций в текущей партии
     * @param array $newPositions
     * @throws \Throwable
     */
    public function updatePositions(array $newPositions)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            array_map(function ($position) {
                $position->delete();
            }, $this->positions);
            $this->addPositions($newPositions);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
