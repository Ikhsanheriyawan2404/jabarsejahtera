<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Disabilitas']);
        Category::create(['name' => 'Yatim Piatu']);
        Category::create(['name' => 'Bencana Alam']);
    }
}
