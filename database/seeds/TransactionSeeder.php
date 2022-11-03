<?php

use Faker\Factory;
use App\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $nominal = [20000, 50000, 10000, 100000, 30000];
        $faker = Factory::create();
        for($i = 0; $i < 1000; $i++) {
            // $record = Transaction::latest()->first();
            // if (isset($record)){
            //     $expNum = explode('-', $record->code_transaction);
            //     $nextInvoiceNumber = $expNum[0].'-'. 'DNS' .'-'. $expNum[2] . '-' . ($expNum[3]+'1');
            // } else {
            //     $nextInvoiceNumber = 'INV-DNS-' . date('dm') .'-10001';
            // }
            Transaction::create([
                // 'code_transaction' => $nextInvoiceNumber,
                'nominal' => (int)$nominal[array_rand($nominal)],
                'payment_status' => 2,
                'donation_id' => rand(1,30),
                'user_id' => null,
                'name' => $faker->name,
                'phone_number' => $faker->phoneNumber,
            ]);
        }
    }
}
