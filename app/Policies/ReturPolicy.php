<?php

namespace App\Policies;

use App\Models\Retur;
use App\Models\User;
use App\Models\DetailTransaksi; // Import ini

class ReturPolicy
{
    public function view(User $user, Retur $retur): bool
    {
        return $user->id_user === $retur->detailTransaksi->transaksi->id_user;
    }

    /**
     * Logic create menerima User dan DetailTransaksi yang ingin diretur
     */
    public function create(User $user, DetailTransaksi $detailTransaksi): bool
    {
        // 1. Pastikan user adalah pemilik transaksi
        // 2. Pastikan status pengiriman sudah 'selesai'
        return $user->id_user === $detailTransaksi->transaksi->id_user &&
               $detailTransaksi->transaksi->status_pengiriman === 'selesai';
    }
}