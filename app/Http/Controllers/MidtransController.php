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

        if ($transaksi) {
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $transaksi->status_pembayaran = 'challenge';
                    } else {
                        $transaksi->status_pembayaran = 'paid';
                        $transaksi->status_pengiriman = 'diproses';
                    }
                }
            } elseif ($transaction == 'settlement') {
                $transaksi->status_pembayaran = 'paid';
                $transaksi->status_pengiriman = 'diproses';
            } elseif ($transaction == 'pending') {
                $transaksi->status_pembayaran = 'pending';
            } elseif ($transaction == 'deny') {
                $transaksi->status_pembayaran = 'denied';
                $transaksi->status_pengiriman = 'dibatalkan';
            } elseif ($transaction == 'expire') {
                $transaksi->status_pembayaran = 'expired';
                $transaksi->status_pengiriman = 'dibatalkan';
            } elseif ($transaction == 'cancel') {
                $transaksi->status_pembayaran = 'failed';
                $transaksi->status_pengiriman = 'dibatalkan';
            }

            $transaksi->save();
        }

        return response()->json(['status' => 'ok']);
    }
}
