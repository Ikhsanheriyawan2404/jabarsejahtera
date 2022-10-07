<?php

namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Support\Str;
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
        // Let's truncate our existing records to start from scratch.
        Donation::truncate();

        $faker = \Faker\Factory::create();

        $type = ['Bencana Alam', 'Disabilitas', 'Yatim Piatu'];
        $title = $faker->sentence;
        for ($i = 0; $i < 50; $i++) {
            Donation::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'image' => 'default.jpg',
                'type' => 'Disabilitas',
                'description' => $faker->paragraph,
            ]);
        }
    }
}
