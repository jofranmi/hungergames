<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Tribute;
use App\Services\Event\EventHandlerService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class GameController
 * @package App\Http\Controllers
 */
class GameController extends Controller
{
	/**
	 * @var EventHandlerService $eventHandlerService
	 */
	protected $eventHandlerService;

	/**
	 * @var Game $game
	 */
	protected $game;

	/**
	 * GameController constructor.
	 * @param EventHandlerService $eventHandlerService
	 * @param Game $game
	 */
	public function __construct(EventHandlerService $eventHandlerService, Game $game)
	{
		$this->eventHandlerService = $eventHandlerService;
		$this->game = $game;
	}

    /**
     * @return bool
     * @throws Exception
     */
	public function advance()
	{
		// Find the current game
		$game = $this->game->find(1);

		// If the game doesn't exit, return an error message
		if (!$game) {
			return false;
		}

		$results = $this->eventHandlerService->advanceTurn($game);

        return view('advance')->with('results', $results);
	}
}
