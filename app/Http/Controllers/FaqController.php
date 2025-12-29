<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Kategori;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {

        $categories = \App\Models\KategoriFaq::with('faqs')->get();
        return view('page.faq', compact('categories'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        Faq::create($request->all());
        return back()->with('success', 'FAQ berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $faq = Faq::findOrFail($id);
        $faq->update($request->all());
        return back()->with('success', 'FAQ berhasil diupdate');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        Faq::destroy($id);
        return back()->with('success', 'FAQ dihapus');
    }
}
