<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $arrayValues = ['Bencana Alam', 'Yatim Piatu', 'Kaum Dhuafa', 'Disabilitas'];
        $title = $faker->sentence;
        for ($i = 0; $i < 50; $i++) {
            Event::create([
                'title' => $title,
                'organizer' => $title,
                'location' => $title,
                'date' => $faker->date,
                'slug' => Str::slug($title),
                'image' => 'default.jpg',
                'category' => $arrayValues[rand(0,3)],
                'description' => $faker->paragraph,
            ]);
        }
    }
}
