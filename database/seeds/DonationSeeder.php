<?php

use App\Donation;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = ['Bencana Alam', 'Disabilitas', 'Yatim Piatu'];
        $faker = Factory::create();
        for($i = 0; $i < 30; $i++) {
            Donation::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'total_budget' => $faker->randomDigitNotNull,
                'category' => $category[array_rand($category)]
            ]);
        }
    }
}
