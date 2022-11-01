<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\API\V1\TransactionController;

Route::get('donations', [OrderController::class, 'donation']);
Route::get('donations/{donation}', [OrderController::class, 'detail_donation'])->name('donation');

Route::get('donations/form/{donation}', [OrderController::class, 'form_donation'])->name('donation.form');
Route::get('transactions', [OrderController::class, 'index'])->name('transaction.index');
Route::post('transactions/{donation}', [OrderController::class, 'store_transaction'])->name('transaction.store');
Route::get('transactions/{transaction}', [OrderController::class, 'proccess_transaction'])->name('transaction.process');

Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

