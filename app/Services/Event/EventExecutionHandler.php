<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Traits\Tribute\TributeKillTrait;
use Illuminate\Support\Collection;

/**
 * Class EventExecutionHandler
 * @package App\Services\Event
 */
class EventExecutionHandler
{
	use TributeKillTrait;

	public function __construct()
	{

	}

	public function executeEvent(Event $event, Collection $participants)
	{
		$eventString = $event->description;
		$reverseParticipants = $participants->reverse();
		$toDie = $event->deaths;
		$killCount = $toDie;
		$deaths = $toDie != 0;

		// Participants are killed in reverse order
		foreach ($reverseParticipants as $index => $tribute) {
			// Array starts at 0 :^)
			$index += 1;
			// {(int)}
			$eventString = str_replace('{' . $index . '}', $tribute->name, $eventString);

			// If people are due to die
			if ($deaths) {
				// Kill them if there are people left to die
				if ($toDie > 0) {
					$this->killTribute($tribute);
					$toDie -= 1;
				}
				// Otherwise add total kill count to survivors
				else {
					$this->addKillCount($tribute, $killCount);
				}
			}
		}

		return $eventString;
	}
}