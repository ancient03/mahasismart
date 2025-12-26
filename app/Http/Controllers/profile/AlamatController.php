<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Alamat;

class AlamatController extends Controller
{
    /**
     * Menampilkan daftar alamat milik pengguna yang sedang login.
     */
    public function index()
    {
        $alamatList = Auth::user()->alamat()->orderByDesc('is_default')->get();
        return view('page.profile.alamat', ['alamatList' => $alamatList]);
    }

    /**
     * Menampilkan form untuk membuat alamat baru.
     */
    public function create()
    {
        return view('page.profile.alamat-create'); 
    }

    /**
     * Menyimpan alamat baru ke database.
     */
    
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
    }

    /**
     * Memperbarui alamat yang sudah ada di database.
     */
    public function update(Request $request, Alamat $alamat)
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

    /**
     * Menghapus alamat dari database.
     */
    public function destroy(Alamat $alamat)
    {
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $alamat->delete();

        return redirect()->route('alamat.index')->with('status', 'Alamat berhasil dihapus!');
    }

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