<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenilaian;
use Illuminate\Http\Request;
use App\Http\Requests\KriteriaPenilaianUpdateRequest;

class KriteriaPenilaianController extends Controller
{

    public function index()
    {
        $kriterias = KriteriaPenilaian::all();

        return view('kriterias.index', compact('kriterias'));
    }


    public function create()
    {
        return view('kriterias.index');
    }


    public function store(KriteriaPenilaianUpdateRequest $request)
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


    public function show(string $id)
    {
        return view('kriterias.index');
    }


    public function edit(string $id)
    {
        return view('kriterias.index', compact('kriteriaPenilaian'));
    }

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

    public function destroy(KriteriaPenilaian $kriteriapenilaian)
    {
        $kriteriapenilaian->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}
