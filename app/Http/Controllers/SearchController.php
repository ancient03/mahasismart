<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // Import model Barang
use Illuminate\View\View; // Import View

class SearchController extends Controller
{
    /**
     * Menampilkan halaman hasil pencarian.
     * Method ini akan dipanggil oleh route GET /search
     */
    public function index(Request $request): View
    {
        // 1. Ambil kata kunci pencarian dari URL (misal: /search?q=phoebe)
        $query = $request->input('q');

        // 2. Siapkan query pencarian
        $barangQuery = Barang::with('toko'); // Eager load relasi toko

        // 3. Lakukan pencarian JIKA ada query
        if ($query) {
            $barangQuery->where('nama_barang', 'LIKE', "%{$query}%");
            // Anda juga bisa menambahkan pencarian di kolom lain jika mau
            // ->orWhere('deskripsi', 'LIKE', "%{$query}%") 
        }

        // 4. Ambil data dengan pagination (12 barang per halaman)
        $barangList = $barangQuery->latest()->paginate(12);

        // 5. Kirim data hasil pencarian dan kata kuncinya ke view
        //    Pastikan path view 'page.search' sudah benar
        return view('page.search', [
            'barangList' => $barangList,
            'query' => $query // Kirim kata kunci pencarian ke view
        ]);
    }
}