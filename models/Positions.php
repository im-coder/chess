<?php

namespace micro\models;

use yii\db\ActiveRecord;

/**
 * Шахматные позиции
 * @package micro\models
 *
 * @property int $game_id
 * @property string $board
 * @property string $figure
 * @property string $color
 *
 * @property Games $game
 */
class Positions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'positions';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['game_id','board','figure','color'], 'required'],
            ['game_id', 'integer'],
            ['game_id', 'exist', 'skipOnError' => true, 'targetClass' => Games::class,
                'targetAttribute' => ['game_id' => 'id']],
            [['game_id','board'], 'unique', 'targetAttribute' => ['game_id','board']],
            [['board','figure','color'], 'string'],
            ['board', 'match', 'pattern' => '/^[a-h][1-8]$/i'],
            ['figure', 'in', 'range' => ['K','Q','R','N','B','p']],
            ['color', 'in', 'range' => ['w','b']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'game_id' => 'Номер партии',
            'board'   => 'Позиция на доске',
            'figure'  => 'Название фигуры',
            'color'   => 'Цвет фигуры',
        ];
    }

    /**
     * Связь с моделью шахматных партий
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasOne(Games::class, ['id' => 'game_id']);
    }
}
