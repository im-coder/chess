<?php

use yii\db\Migration;

/**
 * Шахматные позиции
 */
class m191104_085629_create_positions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('positions', [
            'game_id' => $this->integer(10)->unsigned()->notNull(),
            'board' => $this->char(2)->notNull(),
            'figure' => $this->char(1)->notNull(),
            'color' => $this->char(1)->notNull(),
            'PRIMARY KEY(game_id, board)',
        ]);
        
        $this->addForeignKey(
            'positions_game_id_games_id_fk',
            'positions',
            'game_id',
            'games',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'positions_game_id_games_id_fk',
            'positions'
        );
        $this->dropTable('positions');
    }
}
