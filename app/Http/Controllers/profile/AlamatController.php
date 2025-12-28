<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Alamat;
=======
use App\Models\Alamat; // Pastikan Model Alamat ada dan benar
use Illuminate\Validation\Rule; // Untuk validasi unique saat update
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4

class AlamatController extends Controller
{
    /**
     * Menampilkan daftar alamat milik pengguna yang sedang login.
     */
    public function index()
    {
<<<<<<< HEAD
        $alamatList = Auth::user()->alamat()->orderByDesc('is_default')->get();
        return view('page.profile.alamat', ['alamatList' => $alamatList]);
=======
        // Ambil hanya alamat milik user yang login, urutkan berdasarkan is_default
        $alamatList = Auth::user()->alamat()->orderByDesc('is_default')->get();

        return view('page.profile.alamat', [
            'alamatList' => $alamatList
        ]);
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
    }

    /**
     * Menampilkan form untuk membuat alamat baru.
     */
<<<<<<< HEAD
    public function create()
    {
=======
/**
     * Menampilkan form untuk membuat alamat baru.
     */
    public function create()
    {
        // HARUSNYA HANYA BARIS INI:
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
        return view('page.profile.alamat-create'); 
    }

    /**
     * Menyimpan alamat baru ke database.
     */
<<<<<<< HEAD
    
public function store(Request $request)
{
    $validated = $request->validate([
        'label' => ['required', 'string', 'max:255'],
        'nama_penerima' => ['required', 'string', 'max:255'],
        'no_hp_penerima' => ['required', 'string', 'max:20'],
        'province_id' => ['required', 'string'],      // Validasi ID
        'city_id' => ['required', 'string'],          // Validasi ID
        'district_id' => ['nullable', 'string'],      // Opsional
        'provinsi' => ['required', 'string', 'max:255'],
        'kota' => ['required', 'string', 'max:255'],
        'kecamatan' => ['required', 'string', 'max:255'],
        'desa' => ['required', 'string', 'max:255'],
        'kode_pos' => ['required', 'string', 'max:10'],
        'detail_alamat' => ['required', 'string'],
        'is_default' => ['sometimes', 'boolean'],
    ]);

    $validated['id_user'] = Auth::id();
    $validated['is_default'] = $request->has('is_default');

    if ($validated['is_default']) {
        Auth::user()->alamat()->update(['is_default' => false]);
    }

    Alamat::create($validated);

    return redirect()->route('alamat.index')->with('status', 'Alamat baru berhasil ditambahkan!');
}

    /**
     * Menampilkan form untuk mengedit alamat.
     */
    public function edit(Alamat $alamat)
    {
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('page.profile.alamat-edit', ['alamat' => $alamat]);
=======
    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'nama_penerima' => ['required', 'string', 'max:255'],
            'no_hp_penerima' => ['required', 'string', 'max:20'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kode_pos' => ['required', 'string', 'max:10'],
            'detail_alamat' => ['required', 'string'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        $validated['id_user'] = Auth::id();
        $validated['is_default'] = $request->has('is_default');

        // Jika alamat baru ini default, nonaktifkan default alamat lain
        if ($validated['is_default']) {
            Auth::user()->alamat()->update(['is_default' => false]);
        }

        Alamat::create($validated);

        return redirect()->route('alamat.index')->with('status', 'Alamat baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit alamat.
     * Kita menggunakan Route Model Binding (Alamat $alamat)
     * Laravel akan otomatis mencari Alamat berdasarkan ID di URL.
     */
    public function edit(Alamat $alamat)
    {
        // Pastikan user hanya bisa mengedit alamat miliknya sendiri
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.'); // Tampilkan error jika bukan miliknya
        }

        return view('page.profile.alamat-edit', [
            'alamat' => $alamat
        ]);
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
    }

    /**
     * Memperbarui alamat yang sudah ada di database.
     */
    public function update(Request $request, Alamat $alamat)
<<<<<<< HEAD
{
    if ($alamat->id_user !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $validated = $request->validate([
        'label' => ['required', 'string', 'max:255'],
        'nama_penerima' => ['required', 'string', 'max:255'],
        'no_hp_penerima' => ['required', 'string', 'max:20'],
        'province_id' => ['required', 'string'],      // Validasi ID
        'city_id' => ['required', 'string'],          // Validasi ID
        'district_id' => ['nullable', 'string'],      // Opsional
        'provinsi' => ['required', 'string', 'max:255'],
        'kota' => ['required', 'string', 'max:255'],
        'kecamatan' => ['required', 'string', 'max:255'],
        'desa' => ['required', 'string', 'max:255'],
        'kode_pos' => ['required', 'string', 'max:10'],
        'detail_alamat' => ['required', 'string'],
        'is_default' => ['sometimes', 'boolean'],
    ]);

    $validated['is_default'] = $request->has('is_default');

    if ($validated['is_default']) {
        Auth::user()->alamat()->where('id_alamat', '!=', $alamat->id_alamat)->update(['is_default' => false]);
    }

    $alamat->update($validated);

    return redirect()->route('alamat.index')->with('status', 'Alamat berhasil diperbarui!');
}

=======
    {
        // Pastikan user hanya bisa mengupdate alamat miliknya sendiri
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi Input (mirip store, tapi unique check diabaikan jika label sama)
         $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'nama_penerima' => ['required', 'string', 'max:255'],
            'no_hp_penerima' => ['required', 'string', 'max:20'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kode_pos' => ['required', 'string', 'max:10'],
            'detail_alamat' => ['required', 'string'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        $validated['is_default'] = $request->has('is_default');

        // Jika alamat ini jadi default, nonaktifkan default alamat lain
        if ($validated['is_default']) {
            Auth::user()->alamat()->where('id_alamat', '!=', $alamat->id_alamat)->update(['is_default' => false]);
        }

        // Update data alamat
        $alamat->update($validated);

        return redirect()->route('alamat.index')->with('status', 'Alamat berhasil diperbarui!');
    }

>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
    /**
     * Menghapus alamat dari database.
     */
    public function destroy(Alamat $alamat)
    {
<<<<<<< HEAD
=======
        // Pastikan user hanya bisa menghapus alamat miliknya sendiri
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

<<<<<<< HEAD
=======
        // Hapus alamat
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
        $alamat->delete();

        return redirect()->route('alamat.index')->with('status', 'Alamat berhasil dihapus!');
    }
<<<<<<< HEAD

    // ============================================================================
    // API METHODS UNTUK RAJAONGKIR
    // ============================================================================

    /**
     * API: Get Provinsi
     */
    public function getProvinsi()
    {
        try {
            $apiKey = config('services.rajaongkir.key', env('RAJA_ONGKIR_API_KEY'));
            
            Log::info('📡 Fetching Provinsi from RajaOngkir...');

            $response = Http::timeout(30)
                ->withHeaders([
                    'key' => $apiKey,
                    'accept' => 'application/json',
                ])
                ->get('https://rajaongkir.komerce.id/api/v1/destination/province');
            
            Log::info('📡 Response Status: ' . $response->status());

            if ($response->successful()) {
                $data = $response->json();
                Log::info('✅ Successfully fetched provinces', ['count' => count($data['data'] ?? [])]);
                return response()->json($data);
            }
            
            Log::error('❌ Failed to fetch provinces: ' . $response->status());
            return response()->json([
                'error' => 'Failed to fetch provinces',
                'message' => $response->body(),
                'status' => $response->status()
            ], $response->status());
            
        } catch (\Exception $e) {
            Log::error('💥 Exception fetching provinces: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get Kota by Province ID
     */
    public function getKota($province_id)
    {
        try {
            $apiKey = config('services.rajaongkir.key', env('RAJA_ONGKIR_API_KEY'));
            
            Log::info("🏙️ Fetching cities for province ID: {$province_id}");
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'key' => $apiKey,
                    'accept' => 'application/json',
                ])
                ->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$province_id}");
            
            Log::info('📡 City Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                Log::info('✅ Successfully fetched cities', ['count' => count($data['data'] ?? [])]);
                return response()->json($data);
            }
            
            Log::error("❌ Failed to fetch cities: " . $response->body());
            return response()->json([
                'error' => 'Failed to fetch cities',
                'message' => $response->body()
            ], $response->status());
            
        } catch (\Exception $e) {
            Log::error('💥 Exception fetching cities: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get Kecamatan by City ID
     */
    public function getKecamatan($city_id)
    {
        try {
            $apiKey = config('services.rajaongkir.key', env('RAJA_ONGKIR_API_KEY'));
            
            Log::info("🗺️ Fetching districts for city ID: {$city_id}");
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'key' => $apiKey,
                    'accept' => 'application/json',
                ])
                ->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$city_id}");
            
            Log::info('📡 District Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                Log::info('✅ Successfully fetched districts', ['count' => count($data['data'] ?? [])]);
                return response()->json($data);
            }
            
            Log::error("❌ Failed to fetch districts: " . $response->body());
            return response()->json([
                'error' => 'Failed to fetch districts',
                'message' => $response->body()
            ], $response->status());
            
        } catch (\Exception $e) {
            Log::error('💥 Exception fetching districts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get Desa/Subdistrict - MENGGUNAKAN DOMESTIC DESTINATION ENDPOINT
     */
    public function getDesa($city_name)
    {
        try {
            $apiKey = config('services.rajaongkir.key', env('RAJA_ONGKIR_API_KEY'));
            
            Log::info("🏘️ Fetching subdistricts for city: {$city_name}");
            
            // Gunakan endpoint domestic-destination dengan search parameter
            $response = Http::timeout(30)
                ->withHeaders([
                    'key' => $apiKey,
                    'accept' => 'application/json',
                ])
                ->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
                    'search' => $city_name,
                    'limit' => 999
                ]);
            
            Log::info('📡 Subdistrict Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Filter data berdasarkan kecamatan yang dipilih
                if (isset($data['data']) && is_array($data['data'])) {
                    Log::info('✅ Successfully fetched subdistricts', ['count' => count($data['data'])]);
                    return response()->json($data);
                }
                
                return response()->json([
                    'data' => []
                ]);
            }
            
            Log::error("❌ Failed to fetch subdistricts: " . $response->body());
            return response()->json([
                'error' => 'Failed to fetch subdistricts',
                'message' => $response->body()
            ], $response->status());
            
        } catch (\Exception $e) {
            Log::error('💥 Exception fetching subdistricts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
=======
}

>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
