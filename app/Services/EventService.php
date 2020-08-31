<?php

namespace App\Services;

use App\Event;
use App\Game;
use Illuminate\Support\Collection;

/**
 * Class EventService
 * @package App\Services
 */
class EventService
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

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param Game $game
     * @param int $tributeCount
     * @param int $tributesRemaining
     * @return array
     */
    public function makeEvent(Game $game, int $tributeCount, int $tributesRemaining): Event
    {
        $event = null;

        // Trigger the showdown
        /*if ($tributesRemaining == 2) {
            return $this->event->find(2);
        }*/

        while ($event == null) {
            $tributesToPlay = $this->weights[rand(0, 11)];

            $events = $this->event
                ->where('tributes', $tributesToPlay)
                ->get();

            if (!$events) {
                continue;
            }

            $eventWeights = $this->getEventWeights($events);

            $eventIdToPlay = $eventWeights[rand(0, ($eventWeights->count() - 1))];

            $event = $this->event->find($eventIdToPlay);

            // If tribute use overflows or less than 2 tributes remain alive, roll for events again
            if (($tributeCount - $event->tributes) < 0 || ($tributesRemaining - $event->kills) <= 1) {
                $event = null;
            }
        }

        return $event;
    }

    /**
     * @param Collection $events
     * @return Collection
     */
    private function getEventWeights(Collection $events): Collection
    {
        $eventWeights = collect([]);

        foreach ($events as $event) {
            $weight = $event->weight;

            for ($i = 1; $i <= $weight; $i++) {
                $eventWeights->push($event->id);
            }
        }

        return $eventWeights;
    }
}
