<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Traits\Tribute\TributeActionsTrait;
use Illuminate\Support\Collection;

/**
 * Class EventExecutionService
 * @package App\Services\Event
 */
class EventExecutionService
{
	use TributeActionsTrait;

	public function __construct()
	{

	}

	/**
	 * @param Event $event
	 * @param Collection $participants
	 * @return string
	 */
	public function executeEvent(Event $event, Collection $participants)
	{
		$eventString = $event->description;
		$orderArray = $participants;
		$toDie = $event->deaths;
		$killCount = $toDie;
		$deaths = $toDie != 0;

		/**
		 * POWER LOGIC
		 */
		$orderArray->transform(function ($tribute) {
			$this->updatePowerRoll($tribute);
			return $tribute;
		});

		$orderArray = $orderArray->sortBy('power_roll');

		// Participants are killed in reverse order
		foreach ($orderArray->reverse() as $index => $tribute) {
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