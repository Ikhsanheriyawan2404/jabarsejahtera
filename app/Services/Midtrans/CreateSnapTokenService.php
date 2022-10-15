<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $transaction;

    public function __construct($transaction)
    {
        parent::__construct();

        $this->transaction = $transaction;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->transaction->code_transaction,
                'gross_amount' => $this->transaction->total_price,
            ],
            'donation' => [
                [
                    'id' => 1,
                    'total_budget' => '150000',
                    'title' => 'Flashdisk Toshiba 32GB',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic quibusdam error tempora esse sapiente accusamus rem quae quo temporibus corrupti dolor excepturi, vero provident ut aperiam illo commodi numquam a',
                ],
            ],
            'customer_details' => [
                'name' => 'Martin Mulyo Syahidin',
                'email' => 'mulyosyahidin95@gmail.com',
                'phone_number' => '081234567890',
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
