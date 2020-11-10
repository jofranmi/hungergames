<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\EventType;
use App\Traits\Tribute\TributeActionsTrait;
use Exception;
use Illuminate\Support\Collection;

/**
 * Class EventExecutionService
 * @package App\Services\Event
 */
class EventExecutionService
{
    use TributeActionsTrait;

    /**
     * @var EventType $eventType
     */
    protected $eventType;

    /**
     * EventExecutionService constructor.
     * @param EventType $eventType
     */
    public function __construct(EventType $eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @param Event $event
     * @param Collection $participants
     * @return Collection
     * @throws Exception
     */
    public function executeEvent(Event $event, Collection $participants): Collection
    {
        switch ($event->type) {
            case $this->eventType::POSITIVE:
                $result = $this->executePositiveEvent($event, $participants);
                break;
            case $this->eventType::NEUTRAL:
            case $this->eventType::STARTING:
                $result = $this->executeNeutralEvent($event, $participants);
                break;
            case $this->eventType::NEGATIVE:
                $result = $this->executeNegativeEvent($event, $participants);
                break;
            case $this->eventType::ENDING:
                $result = $this->executeEndingEvent($event, $participants);
                break;
            default:
                throw new Exception('Event has no type.');
        }

        return $result;
    }

    /**
     * @param Event $event
     * @param Collection $participants
     * @return Collection
     */
    public function executeNeutralEvent(Event $event, Collection $participants): Collection
    {
        $eventString = $event->description;

        foreach ($participants as $index => $tribute) {
            // Array starts at 0 :^)
            $index += 1;
            // {(int)}
            $eventString = $this->replaceIndexWithTributeName($index , $tribute->name, $eventString);
        }

        $result = collect([
            'description' => $eventString,
            'tributes' => collect(['alive' => $participants])
        ]);

        return $result;
    }

    /**
     * @param Event $event
     * @param Collection $participants
     * @return Collection
     */
    public function executeNegativeEvent(Event $event, Collection $participants): Collection
    {
        $eventString = $event->description;
        $orderArray = $participants;
        $toDie = $event->deaths;
        $killCount = $toDie;
        $alive = collect();
        $dead = collect();

        /**
         * POWER LOGIC
         */
        $orderArray->transform(function ($tribute) {
            $this->updatePowerRoll($tribute);
            return $tribute;
        });

        // Participants are killed in reverse order
        $orderArray = $orderArray->sortBy('power_roll', 0, true);

        foreach ($orderArray as $index => $tribute) {
            // Array starts at 0 :^)
            $index += 1;
            // {(int)}
            $eventString = $this->replaceIndexWithTributeName($index , $tribute->name, $eventString);

            // Kill the tribute if there are tributes left to die
            if ($toDie > 0) {
                $dead->push($tribute);
                $this->killTribute($tribute);
                $toDie -= 1;
            }
            // Otherwise add total kill count to the survivors
            else {
                $alive->push($tribute);
                $this->addKillCount($tribute, $killCount);
            }
        }

        $result = collect([
            'description' => $eventString,
            'tributes' => collect([
                'alive' => $alive,
                'dead' => $dead
            ])
        ]);

        return $result;
    }

    public function executeEndingEvent()
    {

    }

    /**
     * @param int $index
     * @param string $tributeName
     * @param string $eventString
     * @return string
     */
    private function replaceIndexWithTributeName(int $index, string $tributeName, string $eventString): string
    {
        return str_replace('{' . $index . '}', $tributeName, $eventString);
    }
}