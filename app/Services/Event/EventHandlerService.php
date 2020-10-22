<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Game;
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
	 * EventHandlerService constructor.
	 * @param EventExecutionService $eventExecutionService
	 * @param EventPickerService $eventPickerService
	 * @param EventType $eventType
	 */
	public function __construct(EventExecutionService $eventExecutionService, EventPickerService $eventPickerService, EventType $eventType)
	{
		$this->eventExecutionService = $eventExecutionService;
		$this->eventPickerService = $eventPickerService;
		$this->eventType = $eventType;
	}

	/**
	 * @param Game $game
	 */
	public function advanceTurn(Game $game)
	{
		// Get the alive tributes for the game
		$tributes = $game->tributes->filter(function ($tribute) {
			return $tribute->dead == 0;
		});

		// Count the tributes
		$tributeCount = $tributes->count();
		$tributesRemaining = $tributeCount;

		$r = collect([]);

		$events = collect();

		// Roll events until there are no more participants left
		while ($tributeCount != 0) {
			$log = collect([
				'remaining' => $tributeCount,
				'alive' => $tributesRemaining
			]);

			$event = $this->eventPickerService->pickEvent($tributeCount, $tributesRemaining);
			$participants = $this->selectEventParticipants($tributes, $event);
			$result = $this->eventExecutionService->executeEvent($event, $participants);

			$events->push($result);

			$tributeCount -= $event->participants;
			$tributesRemaining -= $event->deaths;

			$r->push($log->merge([
				'participating' => $log['remaining'] - $tributeCount,
				'killed' => $log['alive'] - $tributesRemaining,
				'event' => $event->description,
			]));
		}

		dd($r, $events);
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

			// If the event is negative and the participants are from the same district, roll again
			if ($event->type == $this->eventType::NEGATIVE && $tributes[$key]->district == $tributes->last()->district) {
				$key = $tributes->keys()->random();
			}

			$tribute = $tributes->pull($key);
			$participants->push($tribute);
		}

		return $participants;
	}
}
