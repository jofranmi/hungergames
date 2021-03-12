<?php

namespace App\Traits\Game;

use App\Models\Game;

/**
 * Trait GameActionsTrait
 * @package App\Traits\Game
 */
trait GameActionsTrait
{
    /**
     * @param Game $game
     */
    private function flipDay(Game $game)
    {
        $game->day = !$game->day;
        $game->save();
    }

    /**
     * @param Game $game
     */
    private function advanceRound(Game $game)
    {
        $game->round = $game->round + 1;
        $game->save();
    }
}
