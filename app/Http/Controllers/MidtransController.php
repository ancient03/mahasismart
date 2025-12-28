<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans notification received', $payload);

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $signatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));

        if ($payload['signature_key'] != $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaksi::where('nomor_invoice', $orderId)->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $status = $payload['transaction_status'];

        if ($status == 'capture') {
            if ($payload['fraud_status'] == 'accept') {
                $transaction->status_pembayaran = 'paid';
                $message = 'Pembayaran berhasil diterima.';
            }
        } else if ($status == 'settlement') {
            $transaction->status_pembayaran = 'paid';
            $message = 'Pembayaran berhasil diselesaikan.';
        } else if ($status == 'pending') {
            $transaction->status_pembayaran = 'pending';
            $message = 'Menunggu pembayaran.';
        } else if ($status == 'deny') {
            $transaction->status_pembayaran = 'failed';
            $message = 'Pembayaran ditolak.';
        } else if ($status == 'expire') {
            $transaction->status_pembayaran = 'failed';
            $message = 'Pembayaran kadaluarsa.';
        } else if ($status == 'cancel') {
            $transaction->status_pembayaran = 'failed';
            $message = 'Pembayaran dibatalkan.';
        }

        $transaction->save();

        Notification::create([
            'id_user' => $transaction->id_user,
            'title' => 'Update Status Pembayaran',
            'message' => $message . ' untuk invoice ' . $transaction->nomor_invoice,
            'url' => route('pesanan.show', $transaction->id_transaksi),
        ]);

        return response()->json(['message' => 'Notification processed']);
    }
}
