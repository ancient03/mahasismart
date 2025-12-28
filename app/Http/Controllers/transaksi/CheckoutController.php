<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Alamat;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\MetodePembayaran;
use App\Models\Notification;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();
        $items = $user->keranjang()->with('toko')->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        $alamatList = $user->alamat()->orderByDesc('is_default')->get();

        $metodePembayaranList = MetodePembayaran::where('is_aktif', true)
                                                 ->where('kode_metode', '!=', 'COD')
                                                 ->orderBy('nama_metode')
                                                 ->get();

        $totalHarga = $items->sum(function($item) {
            return $item->harga * $item->pivot->kuantitas;
        });

        return view('page.products.checkout', [
            'items' => $items,
            'alamatList' => $alamatList,
            'totalHarga' => $totalHarga,
            'metodePembayaranList' => $metodePembayaranList,
            'clientKey' => config('midtrans.client_key'),
            'snapUrl' => config('midtrans.snap_url'),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $items = $user->keranjang()->with('toko')->get();

        if ($items->isEmpty()) {
            return response()->json(['error' => 'Keranjang Anda kosong.'], 400);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id_alamat' => ['required', 'integer', Rule::in($user->alamat->pluck('id_alamat'))],
            'id_metode_pembayaran' => ['required', 'integer', 'exists:metode_pembayaran,id_metode_pembayaran']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $totalHarga = $items->sum(function($item) {
            return $item->harga * $item->pivot->kuantitas;
        });

        try {
            DB::beginTransaction();

            $transaksi = Transaksi::create([
                'id_user' => $user->id_user,
                'id_alamat' => $request->id_alamat,
                'id_metode_pembayaran' => $request->input('id_metode_pembayaran'),
                'nomor_invoice' => 'INV/' . now()->format('Ymd') . '/' . $user->id_user . '/' . time(),
                'total_harga_keseluruhan' => $totalHarga,
                'status_pembayaran' => 'pending',
                'status_pengiriman' => 'belum diproses',
            ]);

            foreach ($items as $item) {
                if (!$item->toko) { throw new \Exception('Barang ' . $item->nama_barang . ' tidak memiliki info toko.'); }
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_barang' => $item->id_barang,
                    'id_toko' => $item->toko->id_toko,
                    'kuantitas' => $item->pivot->kuantitas,
                    'harga_saat_transaksi' => $item->harga,
                ]);
            }

            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $transaksi->nomor_invoice,
                    'gross_amount' => $transaksi->total_harga_keseluruhan,
                ),
                'customer_details' => array(
                    'first_name' => $user->nama,
                    'last_name' => '',
                    'email' => $user->email,
                    'phone' => $user->telepon,
                ),
            );

            $snapToken = Snap::getSnapToken($params);
            $transaksi->snap_token = $snapToken;
            $transaksi->save();

            $user->keranjang()->detach();

            DB::commit();

            Notification::create([
                'id_user' => $user->id_user,
                'title' => 'Pesanan Berhasil Dibuat',
                'message' => 'Pesanan Anda dengan invoice ' . $transaksi->nomor_invoice . ' sedang menunggu pembayaran.',
                'url' => route('pesanan.show', $transaksi->id_transaksi),
            ]);

            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal checkout: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.'], 500);
        }
    }
}

