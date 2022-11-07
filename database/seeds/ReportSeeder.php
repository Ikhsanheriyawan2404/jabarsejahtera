<?php

use App\Report;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i = 0; $i < 10; $i++) {
            Report::create([
                'name' => $faker->name,
                'donation_id' => 1,
                'description' => $faker->sentence,
                'nominal' => 100000,
                'date' => date('Y-m-d'),
            ]);
        }
    }
}
