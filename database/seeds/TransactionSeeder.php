<?php

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
        $record = Transaction::latest()->first();
        if (isset($record)){
            $expNum = explode('-', $record->code_transaction);
            $nextInvoiceNumber = $expNum[0].'-'. 'DNS' .'-'. $expNum[2] . '-' . ($expNum[3]+'1');
        } else {
            $nextInvoiceNumber = 'INV-DNS-' . date('dm') .'-10001';
        }

        Transaction::create([
            'code_transaction' => $nextInvoiceNumber,
            'nominal' => request('nominal'),
            'payment_status' => 1,
            'donation_id' => 1,
            'user_id' => auth('api')->user() ? auth('api')->user()->id : null,
            'name' => auth('api')->user() ? auth('api')->user()->name : request('name'),
            'phone_number' => auth('api')->user() ? auth('api')->user()->user_detail->phone_number : request('phone_number'),
        ]);
    }
}
