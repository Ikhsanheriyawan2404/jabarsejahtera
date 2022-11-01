<?php

namespace App\Http\Controllers\API\V1;

use App\{Donation, Transaction};
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Services\Midtrans\CreateSnapTokenService;

class TransactionController extends Controller
{
    public function getTransactions()
    {
        return new ApiResource(true, 'List Transactions', Transaction::latest()->get());
    }

    public function donation(Donation $donation)
    {
        $this->validate(request(), [
            'name' => 'required|max:255',
            'nominal' => 'required',
            'phone_number' => 'required',
        ]);

        $record = Transaction::latest()->first();
        if (isset($record)){
            $expNum = explode('-', $record->code_transaction);
            $nextInvoiceNumber = $expNum[0].'-'. 'DNS' .'-'. $expNum[2] . '-' . ($expNum[3]+'1');
        } else {
            $nextInvoiceNumber = 'INV-DNS-' . date('dm') .'-10001';
        }

        $transaction = Transaction::create([
            'code_transaction' => $nextInvoiceNumber,
            'nominal' => request('nominal'),
            'payment_status' => 1,
            'donation_id' => $donation->id,
            'user_id' => auth('api')->user() ? auth('api')->user()->id : null,
            'name' => auth('api')->user() ? auth('api')->user()->name : request('name'),
            'phone_number' => auth('api')->user() ? auth('api')->user()->user_detail->phone_number : request('phone_number'),
        ]);

        $snapToken = $transaction->snap_token;
        if (is_null($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database

            $midtrans = new CreateSnapTokenService($transaction);
            $snapToken = $midtrans->getSnapToken();

            $transaction->snap_token = $snapToken;
            $transaction->save();
        }

        return new ApiResource(true, 'Transaksi berhasil dibuat.', $transaction);
    }

    public function zakat()
    {
        $this->validate(request(), [
            'name' => 'required|max:255',
            'nominal' => 'required',
            'phone_number' => 'required',
        ]);

        $record = Transaction::latest()->first();
        if (isset($record)){
            $expNum = explode('-', $record->code_transaction);
            $nextInvoiceNumber = $expNum[0].'-'. 'ZKT' .'-'. $expNum[2] . '-' . ($expNum[3]+'1');
        } else {
            $nextInvoiceNumber = 'INV-ZKT-' . date('dm') .'-10001';
        }

        $transaction = Transaction::create([
            'code_transaction' => $nextInvoiceNumber,
            'nominal' => request('nominal'),
            'payment_status' => 1,
            'user_id' => auth('api')->user() ? auth('api')->user()->id : null,
            'name' => auth('api')->user() ? auth('api')->user()->name : request('name'),
            'phone_number' => auth('api')->user() ? auth('api')->user()->user_detail->phone_number : request('phone_number'),
        ]);

        $snapToken = $transaction->snap_token;
        if (is_null($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database

            $midtrans = new CreateSnapTokenService($transaction);
            $snapToken = $midtrans->getSnapToken();

            $transaction->snap_token = $snapToken;
            $transaction->save();
        }

        return new ApiResource(true, 'Transaksi berhasil dibuat.', $transaction);
    }
}
