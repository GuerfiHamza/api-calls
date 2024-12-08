<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
            \App\Models\Logs::create([
                'title' => $faker->sentence,
                'excerpt' => $faker->sentence,
                'description' => $faker->paragraph,
                'publish_date' => $faker->dateTime,
            ]);
    }
}
