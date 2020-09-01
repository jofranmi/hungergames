<?php

namespace App\Services\Event;

use App\Models\Event;
use Illuminate\Support\Collection;

/**
 * Class EventService
 * @package App\Services\Event
 */
class EventPickerService
{
    /**
     * @var Event $event
     */
    protected $event;

    /**
     * @var array $weights
     */
    protected $weights = [
        1,
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
        6
    ];

	/**
	 * EventPickerService constructor.
	 * @param Event $event
	 */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param int $tributeCount
     * @param int $tributesRemaining
     * @return Event
     */
    public function pickEvent(int $tributeCount, int $tributesRemaining): Event
    {
        // Roll for the amounts of participants
        $participants = $this->calculateParticipants($tributeCount);

        // Get an event where the rolled amount of participants
        $events = $this->event
            ->where('participants', $participants)
            ->get();

        // Removes events that will overflow tribute use or leave less than 2 remaining
        $eventsFiltered = $this->filterEvents($events, $tributeCount, $tributesRemaining);

        // Adds all of the events id into an array by weight
        $eventsWeights = $this->getEventWeights($eventsFiltered);

        // Get the event ID to play
        $eventIdToPlay = $eventsWeights->random();

        // Find said event
        $event = $this->event->find($eventIdToPlay);

        return $event;
    }

    /**
     * @param int $tributeCount
     * @return int
     */
    private function calculateParticipants(int $tributeCount): int
    {
        $weights = collect($this->weights);

        // Remove entries that exceed the current tribute count
        $weightsFiltered = $weights->filter(function ($count) use ($tributeCount) {
            return $count <= $tributeCount;
        });

        $tributesToPlay = $weightsFiltered->random();

        return $tributesToPlay;
    }

    /**
     * Filter events and removes those that will either
     * Use more tributes than available
     * Leave less than 2 tributes alive
     *
     * @param Collection $events
     * @param int $tributeCount
     * @param int $tributesRemaining
     * @return Collection
     */
    private function filterEvents(Collection $events, int $tributeCount, int $tributesRemaining): Collection
    {
        $filteredEvents = $events->filter(function ($event) use ($tributeCount, $tributesRemaining) {
            return (($tributeCount - $event->participants >= 0) && ($tributesRemaining - $event->deaths >= 2));
        });

        return $filteredEvents;
    }

    /**
     * Adds all of the events id into an array by weight
     *
     * @param Collection $events
     * @return Collection
     */
    private function getEventWeights(Collection $events): Collection
    {
        $eventWeights = collect();

        foreach ($events as $event) {
            for ($i = 1; $i <= $event->weight; $i++) {
                $eventWeights->push($event->id);
            }
        }

        return $eventWeights;
    }
}
