<?php

namespace App\Http\Controllers;

use App\Game;
use App\Services\EventService;
use Illuminate\Http\Request;

/**
 * Class GameController
 * @package App\Http\Controllers
 */
class GameController extends Controller
{
    /**
     * @var EventService $eventService
     */
    protected $eventService;

    /**
     * @var Game $game
     */
    protected $game;

    public function __construct(EventService $eventService, Game $game)
    {
        $this->eventService = $eventService;
        $this->game = $game;
    }

    /**
     * @param $gameId
     * @return bool
     */
    public function advance()
    {
        // First, find the game
        $game = $this->game->find(1);

        if (!$game) {
            return false;
        }

        // Get the tributes for the game
        $tributes = $game->tributes->filter(function ($tribute) {
            return $tribute->dead == 0;
        });

        // Count the tributes
        $tributeCount = count($tributes);
        $tributesRemaining = $tributeCount;

        $events = collect([]);
        $r = collect([]);

        // Roll events with a random amount of tributes until they all participate and at least 2 of them remain
        while ($tributeCount != 0) {
            $log = collect([
                'remaining' => $tributeCount,
                'alive' => $tributesRemaining
            ]);

            $event = $this->eventService->makeEvent($game, $tributeCount, $tributesRemaining);

            $tributeCount -= $event->tributes;
            $tributesRemaining -= $event->kills;
            $events->push($event);
            $r->push($log->merge([
                'participating' => $log['remaining'] - $tributeCount,
                'killed' => $log['alive'] - $tributesRemaining
            ]));
        }

        dd($r, $events->pluck('description'));
    }
}
