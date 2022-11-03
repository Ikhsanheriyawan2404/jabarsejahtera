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
        Donation::create([
            'title' => 'Ikhsan Heriyawan',
            'description' => 'sdfdasf',
            'total_budget' => 100000,
            'image' => 'img/default.jpg',
            'category' => 'Disabilitas',
            'location' => 'Cirebon'
        ]);

        $category = ['Bencana Alam', 'Yatim Piatu', 'Disabilitas', 'Kaum Dhuafa', 'Kegiatan Sosial', 'Lingkungan', 'Infrastruktur', 'Bantuan Medis'];
        $faker = Factory::create();
        for($i = 0; $i < 30; $i++) {
            Donation::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'location' => 'kontoljaran',
                'total_budget' => (int)rand(1000000, 10000000),
                'image' => 'img/default.jpg',
                'category' => $category[array_rand($category)]
            ]);
        }
    }
}
