<?php

namespace App\Http\Controllers\API\V1;

use App\Transaction;
use App\Http\Controllers\Controller;
use App\Services\Midtrans\CreateSnapTokenService;

class TransactionController extends Controller
{
    public function store()
    {
        $transaction = Transaction::create([
            'code_transaction' => 'INV-0001',
            'total_price' => 1000.00,
            'payment_status' => 1,
        ]);
        $snapToken = $transaction->snap_token;
        if (is_null($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database

            $midtrans = new CreateSnapTokenService($transaction);
            $snapToken = $midtrans->getSnapToken();

            $transaction->snap_token = $snapToken;
            $transaction->save();
        }
        return view('welcome', compact('transaction', 'snapToken'));
    }
}
