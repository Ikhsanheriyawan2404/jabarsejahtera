<?php

use App\Event;
use Faker\Factory;
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
        $category = ['Bencana Alam', 'Yatim Piatu', 'Disabilitas', 'Kaum Dhuafa', 'Kegiatan Sosial', 'Lingkungan', 'Infrastruktur', 'Bantuan Medis'];
        $faker = Factory::create();
        for($i = 0; $i < 1000; $i++) {
            Event::create([
                'title' => $faker->sentence,
                'organizer' => $faker->name,
                'date' => $faker->dateTime(),
                'location' => $faker->name,
                'description' => $faker->paragraph,
                'image' => 'img/default-banner.jpg',
                'category' => $category[array_rand($category)]
            ]);
        }
    }
}
