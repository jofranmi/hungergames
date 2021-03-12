<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class TributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $name = $faker->firstName;

            DB::table('tributes')->insert([
                'friendly_name' => $name,
                'name' => $name,
                'district' => $i
            ]);
        }
    }
}
