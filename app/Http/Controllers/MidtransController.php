<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('midtrans.is_production');

        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $transaksi = Transaksi::where('nomor_invoice', $orderId)->first();

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'challenge'
                    $transaksi->status_pembayaran = 'challenge';
                } else {
                    // TODO set payment status in merchant's database to 'success'
                    $transaksi->status_pembayaran = 'paid';
                }
            }
        } elseif ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'success'
            $transaksi->status_pembayaran = 'paid';
        } elseif ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'pending'
            $transaksi->status_pembayaran = 'pending';
        } elseif ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'denied'
            $transaksi->status_pembayaran = 'denied';
        } elseif ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $transaksi->status_pembayaran = 'expired';
        } elseif ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'failure'
            $transaksi->status_pembayaran = 'failed';
        }

        $transaksi->save();

        return response()->json(['status' => 'ok']);
    }
}
