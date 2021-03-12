<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Game;
use Exception;
use Illuminate\Support\Collection;

/**
 * Class EventHandlerService
 * @package App\Services\Event
 */
class EventHandlerService
{
	/**
	 * @var EventExecutionService $eventExecutionService
	 */
	protected $eventExecutionService;

	/**
	 * @var EventPickerService $eventPickerService
	 */
	protected $eventPickerService;

	/**
	 * @var EventType $eventType
	 */
	protected $eventType;

    /**
     * Participants weight
     * @var $weights
     */
    protected $weights;

	/**
	 * EventHandlerService constructor.
	 * @param EventExecutionService $eventExecutionService
	 * @param EventPickerService $eventPickerService
	 * @param EventType $eventType
	 */
	public function __construct(EventExecutionService $eventExecutionService, EventPickerService $eventPickerService, EventType $eventType)
	{
        //TODO make weights dynamic
	    $this->weights = collect([1, 2, 3
            /*1,
            1,
            1,
            1,
            2,
            2,
            2,
            3,
            3,
            4,
            5,
            6*/
        ]);

		$this->eventExecutionService = $eventExecutionService;
		$this->eventPickerService = $eventPickerService;
		$this->eventType = $eventType;
	}

    /**
     * @param Game $game
     * @return Collection
     * @throws Exception
     */
	public function advanceTurn(Game $game): Collection
	{
		// Get the alive tributes for the game
		$tributes = $game->tributes->filter(function ($tribute) {
			return $tribute->dead == 0;
		});

		// Count the tributes
		$tributeCount = $tributes->count();
		$tributesRemaining = $tributeCount;

		// Execute ending event
		if ($tributeCount == 2) {
		    return collect([$this->doEventLogic(2, 2, 2, $game, $tributes)->result]);
        }

		$participantsPerEventTotal = collect();

        // Get a random number of events with a random number of participants
		for ($i = $tributesRemaining; $i >= 1;) {
            $participants = $this->weights->filter(function ($weight) use ($i) {
                return $weight <= $i;
            })->random();

            $participantsPerEventTotal->push($participants);
            $i -= $participants;
        }

		$results = collect();

		// Loops through each # of participants and does the logic
		foreach ($participantsPerEventTotal as $participantsPerEvent) {
		    $result = $this->doEventLogic($tributeCount, $tributesRemaining, $participantsPerEvent, $game, $tributes);

		    $tributesRemaining = $result['tributesRemaining'];

            $results->push($result['result']);
        }

		return $results;
	}

    /**
     * @param int $tributeCount
     * @param int $tributesRemaining
     * @param int $participantsPerEvent
     * @param Game $game
     * @param Collection $tributes
     * @return Collection
     * @throws Exception
     */
	private function doEventLogic(int $tributeCount, int $tributesRemaining, int $participantsPerEvent, Game $game, Collection $tributes): Collection
    {
        $event = $this->eventPickerService->pickEvent($tributeCount, $tributesRemaining, $participantsPerEvent, $game);

        // After going through this event, participants are removed from the tribute list
        $participants = $this->selectEventParticipants($tributes, $event);

        $result = $this->eventExecutionService->executeEvent($event, $participants);

        $tributesRemaining -= $event->deaths;

        return collect([
            'result' => $result,
            'tributesRemaining' => $tributesRemaining
        ]);
    }

	/**
	 * @param Collection $tributes
	 * @param Event $event
	 * @return Collection
	 */
	private function selectEventParticipants(Collection $tributes, Event $event): Collection
	{
		$participants = collect();

		for ($i = 1; $i <= $event->participants; $i++) {
			$key = $tributes->keys()->random();

			$tribute = $tributes->pull($key);

			$participants->push($tribute);
		}

		return $participants;
	}
}
