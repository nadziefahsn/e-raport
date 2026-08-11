<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenilaian;
use Illuminate\Http\Request;
use App\Http\Requests\KriteriaPenilaianStoreRequest;
use App\Http\Requests\KriteriaPenilaianUpdateRequest;

class KriteriaPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $kriterias = KriteriaPenilaian::latest()->get();
        // return view('kriterias.index', compact('kriterias'))
        // ->with( (request()->input('page', 1) - 2) * 5);
        $kriterias = KriteriaPenilaian::all();

        return view('kriterias.index', compact('kriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriterias.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KriteriaPenilaianStoreRequest $request)
    {
        $request->validate([
            'kriteria'  => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KriteriaPenilaian::create([
            'kriteria'  => $request->kriteria,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Kriteria berhasil ditambahkan!');
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('kriterias.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('kriterias.index', compact('kriteriaPenilaian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KriteriaPenilaianUpdateRequest $request, KriteriaPenilaian $kriteriaPenilaian, $id)
    {
        $request->validate([
        'kriteria'  => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        ]);

        $data = KriteriaPenilaian::findOrFail($id);
        $data->kriteria  = $request->kriteria;
        $data->deskripsi = $request->deskripsi;
        $data->save();

        return redirect()->back()->with('success', 'Data kriteria berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KriteriaPenilaian $kriteriapenilaian)
    {
        $kriteriapenilaian->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}
