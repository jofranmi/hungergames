<?php

use App\Models\EventType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultStartingEvents();
    }

    private function createDefaultStartingEvents()
    {
        DB::table('events')->insert([
            'description' => '{1} grabs a shovel.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} grabs a backpack and retreats.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} and {2} fight for a bag. {1} gives up and retreats.',
            'type' => EventType::STARTING,
            'participants' => 2,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} finds a bow, some arrows and a quiver.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} runs into the cornucopia and hides.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} takes a handful of throwing knives.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} rips a mace out of {2}\'s hands.',
            'type' => EventType::STARTING,
            'participants' => 2,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} finds a canteen full of water.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} stays at the cornucopia for resources.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} gathers as much resources as they can.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} grabs a sword.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} takes a spear from inside the cornucopia.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} finds a bag full of explosives.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} clutches a first aid kit and runs away.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} takes a sickle from inside the cornucopia.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1}, {2}, and {3} work together to get as many supplies as possible.',
            'type' => EventType::STARTING,
            'participants' => 3,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} runs away with a squirrel, a rope, and a megaphone.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} snatches a bottle of alcohol and a rag.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} finds a backpack full of camping equipment.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} grabs a backpack, not realizing it\'s empty.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} breaks {2}\'s nose for a basket of mouldy bread.',
            'type' => EventType::STARTING,
            'participants' => 2,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1}, {2}, {3}, and {4} share everything they gathered before running,',
            'type' => EventType::STARTING,
            'participants' => 4,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} retrieves a trident from inside the cornucopia.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} grabs a jar of fishing bait while {2} gets fishing gear.',
            'type' => EventType::STARTING,
            'participants' => 2,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} scares {2} away from the cornucopia.',
            'type' => EventType::STARTING,
            'participants' => 2,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} grabs a shield leaning on the cornucopia.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);

        DB::table('events')->insert([
            'description' => '{1} snatches a pair of mom sandals.',
            'type' => EventType::STARTING,
            'participants' => 1,
            'deaths' => 0,
            'weight' => 1,
            'day' => 1,
            'items' => 0,
        ]);
    }
}
