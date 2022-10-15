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
                'order_id' => $this->transaction->uuid,
                'gross_amount' => $this->transaction->nominal,
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $this->transaction->nominal,
                    'name' => isset($this->transaction->donation) ? $this->transaction->donation->title : 'Zakat',
                    'quantity' => 1
                ],
            ],
            'customer_details' => [
                'first_name' => $this->transaction->name,
                'phone' => $this->transaction->phone_number,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
