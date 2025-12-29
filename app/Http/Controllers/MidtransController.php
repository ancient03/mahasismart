<?php

namespace App\Http\Controllers;

// Manually load the Midtrans library to fix class loading issues.
require_once(base_path('vendor/midtrans/midtrans-php/Midtrans.php'));

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Notification as AppNotification; // Import and alias the model
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
            // Hindari notifikasi duplikat jika status tidak berubah
            if ($transaksi->status_pembayaran === 'paid' && $transaction == 'settlement') {
                return response()->json(['status' => 'ok', 'message' => 'Already processed']);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $transaksi->status_pembayaran = 'challenge';
                    } else {
                        $transaksi->status_pembayaran = 'paid';
                        $transaksi->status_pengiriman = 'diproses';
                        AppNotification::create([
                            'id_user' => $transaksi->id_user,
                            'title' => 'Pembayaran Berhasil',
                            'message' => 'Pembayaran untuk invoice ' . $transaksi->nomor_invoice . ' telah berhasil.',
                            'url' => route('pesanan.show', $transaksi->id_transaksi),
                        ]);
                    }
                }
            } elseif ($transaction == 'settlement') {
                $transaksi->status_pembayaran = 'paid';
                $transaksi->status_pengiriman = 'diproses';
                AppNotification::create([
                    'id_user' => $transaksi->id_user,
                    'title' => 'Pembayaran Berhasil',
                    'message' => 'Pembayaran untuk invoice ' . $transaksi->nomor_invoice . ' telah berhasil.',
                    'url' => route('pesanan.show', $transaksi->id_transaksi),
                ]);
            } elseif ($transaction == 'pending') {
                $transaksi->status_pembayaran = 'pending';
            } elseif ($transaction == 'deny') {
                $transaksi->status_pembayaran = 'denied';
                $transaksi->status_pengiriman = 'dibatalkan';
                AppNotification::create([
                    'id_user' => $transaksi->id_user,
                    'title' => 'Pembayaran Ditolak',
                    'message' => 'Pembayaran untuk invoice ' . $transaksi->nomor_invoice . ' ditolak.',
                    'url' => route('pesanan.show', $transaksi->id_transaksi),
                ]);
            } elseif ($transaction == 'expire') {
                $transaksi->status_pembayaran = 'expired';
                $transaksi->status_pengiriman = 'dibatalkan';
                AppNotification::create([
                    'id_user' => $transaksi->id_user,
                    'title' => 'Waktu Pembayaran Habis',
                    'message' => 'Waktu pembayaran untuk invoice ' . $transaksi->nomor_invoice . ' telah habis.',
                    'url' => route('pesanan.show', $transaksi->id_transaksi),
                ]);
            } elseif ($transaction == 'cancel') {
                $transaksi->status_pembayaran = 'failed';
                $transaksi->status_pengiriman = 'dibatalkan';
                 AppNotification::create([
                    'id_user' => $transaksi->id_user,
                    'title' => 'Pembayaran Dibatalkan',
                    'message' => 'Pembayaran untuk invoice ' . $transaksi->nomor_invoice . ' telah dibatalkan.',
                    'url' => route('pesanan.show', $transaksi->id_transaksi),
                ]);
            }

            $transaksi->save();
        }

        return response()->json(['status' => 'ok']);
    }
}
