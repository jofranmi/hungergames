<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
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
     * @param int $participants
     * @param Game $game
     * @return Event
     */
    public function pickEvent(int $tributeCount, int $tributesRemaining, int $participants, Game $game): Event
    {
        // Get an event where the rolled amount of participants
        $eventsQuery = $this->event->where('participants', '=' , $participants);

        // If only 2 tributes remain, execute an ending event
        if ($tributeCount == 2 && $tributesRemaining == 2) {
            $eventsQuery->where('type', $this->eventType::ENDING);
        }
        // If it's the first round and daylight, execute a starting event
        else if ($game->round == 1 && $game->day) {
            $eventsQuery->where('type', $this->eventType::STARTING);
        }
        // Get normal events
        else {
            $eventsQuery->where('type', '!=', [$this->eventType::STARTING, $this->eventType::ENDING])
                ->where('deaths', '<=', $tributesRemaining - 2);
        }

        // Adds all of the events id into an array by weight
        $eventsWeights = $this->getEventWeights($eventsQuery->get());

        // Find said event
        $event = $this->event->find($eventsWeights->random());

        return $event;
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
