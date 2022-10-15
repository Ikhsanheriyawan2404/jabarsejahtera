<?php

namespace App\Http\Controllers;

use App\Donation;
use App\Transaction;
use App\Services\Midtrans\CreateSnapTokenService;

class OrderController extends Controller
{
    public function donation()
    {
        $donations = Donation::all();
        return view('donation', compact('donations'));
    }

    public function detail_donation(Donation $donation)
    {

        return view('detail_donation', compact('donation'));
    }

    public function index()
    {
        $record = Transaction::latest()->first();
        if (isset($record)){
            $expNum = explode('-', $record->code_transaction);
            //increase 1 with last invoice number
            $nextInvoiceNumber = $expNum[0].'-'. $expNum[1] .'-'. ($expNum[2]+1);
        } else {
            $nextInvoiceNumber = 'INV' . '-' . date('dmy') .'-0001';
        }
        $transactions = Transaction::all();

        return view('home', compact('transactions'));
    }

    public function form_donation(Donation $donation)
    {
        return view('form_donation', compact('donation'));
    }

    public function store_transaction(Donation $donation)
    {
        $record = Transaction::latest()->first();
        if (isset($record)){
            $expNum = explode('-', $record->code_transaction);
            //increase 1 with last invoice number
            $nextInvoiceNumber = $expNum[0].'-'. $expNum[1] .'-'. ($expNum[2]+'1');
        } else {
            $nextInvoiceNumber = 'INV' . '-' . date('dmy') .'-10001';
        }

        $transaction = Transaction::create([
            'code_transaction' => $nextInvoiceNumber,
            'nominal' => request('nominal'),
            'payment_status' => 1,
            'donation_id' => $donation->id,
            'user_id' => auth()->user() ? auth()->user()->id : '',
            'name' => request('name'),
            'phone_number' => request('phone_number'),
        ]);

        return redirect()->route('transaction.process', $transaction->id);
    }

    public function proccess_transaction(Transaction $transaction)
    {
        $snapToken = $transaction->snap_token;
        if (is_null($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database

            $midtrans = new CreateSnapTokenService($transaction);
            $snapToken = $midtrans->getSnapToken();

            $transaction->snap_token = $snapToken;
            $transaction->save();
        }
        return view('proccess_transaction', compact('transaction', 'snapToken'));
    }
}
