<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\EventType;
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
     * @var EventType $eventType
     */
    protected $eventType;

    /**
	 * TODO make weights dynamic
	 * Participants weight
     * @var array $weights
     */
    protected $weights = [
        1,
        2
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
    ];

    /**
     * EventPickerService constructor.
     * @param Event $event
     * @param EventType $eventType
     */
    public function __construct(Event $event, EventType $eventType)
    {
        $this->event = $event;
        $this->eventType = $eventType;
    }

    /**
     * @param int $tributeCount
     * @param int $tributesRemaining
     * @param int $round
     * @param bool $day
     * @return Event
     */
    public function pickEvent(int $tributeCount, int $tributesRemaining, int $round, bool $day): Event
    {
        // Roll for the amounts of participants
        $participants = $this->calculateParticipants($tributeCount);

        // Get an event where the rolled amount of participants
        $eventsQuery = $this->event
            ->where('participants', $participants);

        // If it's the first round and daylight, execute a starting event
        if ($tributesRemaining == 2) {
            $eventsQuery->where('type', $this->eventType::ENDING);
        }
        // If it's the first round and daylight, execute a starting event
        else if ($round == 1 && $day) {
            $eventsQuery->where('type', $this->eventType::STARTING);
        }
        // Get normal events
        else {
            $eventsQuery->where('type', '!=', [$this->eventType::STARTING, $this->eventType::ENDING]);
        }

        $events = $eventsQuery->get();

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
