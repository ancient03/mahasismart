<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $toko = Toko::with('barang')->findOrFail($id);
        return view('page.toko.detail', compact('toko'));
    }
}
