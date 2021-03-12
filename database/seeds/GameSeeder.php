<?php

use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert(['name' => 'Dev']);

        for ($i = 1; $i <= 10; $i++) {
            DB::table('game_tribute')->insert([
                'game_id' => 1,
                'tribute_id' => $i
            ]);
        }
    }
}
