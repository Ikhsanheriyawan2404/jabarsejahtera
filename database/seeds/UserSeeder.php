<?php

use App\{User, UserDetail};
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Ikhsan Heriyawan',
            'email' => 'ikhsan@gmail.com',
            'role' => '1',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);

        $user = User::create([
            'name' => 'Ikhsan Kuncoro',
            'email' => 'ikhsan24@gmail.com',
            'role' => '0',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
        ]);

        $faker = Factory::create();
        for($i = 0; $i < 5; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);

            UserDetail::create([
                'id' => $user->id,
                'phone_number' => $faker->name,
            ]);
        }

        Artisan::call('passport:install');
    }
}
