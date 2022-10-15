<?php

namespace App\Http\Controllers\API\V1;

use App\Donation;
use App\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;

class TransactionController extends Controller
{
    public function store(Donation $donation)
    {
        $this->validate(request(), [
            'name' => 'required|max:255',
            'nominal' => 'required',
            'phone_number' => 'required',
        ]);

        $record = Transaction::latest()->first();
        if (isset($record)){
            $expNum = explode('-', $record->code_transaction);
            $nextInvoiceNumber = $expNum[0].'-'. $expNum[1] .'-'. ($expNum[2]+'1');
        } else {
            $nextInvoiceNumber = 'INV' . '-' . date('dmy') .'-10001';
        }

        $transaction = Transaction::create([
            'code_transaction' => $nextInvoiceNumber,
            'nominal' => request('nominal'),
            'payment_status' => 1,
            'donation_id' => $donation->id,
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'name' => request('name'),
            'phone_number' => request('phone_number'),
        ]);

        return new ApiResource(true, 'Transaksi berhasil dibuat', $transaction);
    }

    public function transaction(Transaction $transaction)
    {
        $snapToken = $transaction->snap_token;
        if (is_null($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database

            $midtrans = new CreateSnapTokenService($transaction);
            $snapToken = $midtrans->getSnapToken();

            $transaction->snap_token = $snapToken;
            $transaction->save();
        }
    }
}
