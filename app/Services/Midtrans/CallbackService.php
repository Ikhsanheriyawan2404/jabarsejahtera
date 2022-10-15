<?php

namespace App\Services\Midtrans;

use App\Services\Midtrans\Midtrans;
use App\Transaction;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $transaction;
    protected $serverKey;

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = config('midtrans.server_key');
        $this->_handleNotification();
    }

    public function isSignatureKeyVerified()
    {
        return ($this->_createLocalSignatureKey() == $this->notification->signature_key);
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;

        return ($statusCode == 200 && $fraudStatus && ($transactionStatus == 'capture' || $transactionStatus == 'settlement'));
    }

    public function isExpire()
    {
        return ($this->notification->transaction_status == 'expire');
    }

    public function isCancelled()
    {
        return ($this->notification->transaction_status == 'cancel');
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    protected function _createLocalSignatureKey()
    {
        $transactionId = $this->transaction->uuid;
        $statusCode = $this->notification->status_code;
        $grossAmount = $this->transaction->nominal;
        $serverKey = $this->serverKey;
        $input = $transactionId . $statusCode . $grossAmount . $serverKey;
        $signature = openssl_digest($input, 'sha512');

        return $signature;
    }

    protected function _handleNotification()
    {
        $notification = new Notification();

        $transactionNumber = $notification->order_id;
        $transaction = Transaction::where('uuid', $transactionNumber)->first();

        $this->notification = $notification;
        $this->transaction = $transaction;
    }
}
