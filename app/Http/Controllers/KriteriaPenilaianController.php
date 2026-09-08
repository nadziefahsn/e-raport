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
        KriteriaPenilaian::create($request->validated());

        return redirect()->back()->with('success', 'Kriteria berhasil ditambahkan!');
        }


    public function show(string $id)
    {
        return view('kriterias.index');
    }


    public function edit(string $id)
    {
        $kriteriapenilaian = KriteriaPenilaian::findOrFail($id);
        $kriterias = KriteriaPenilaian::all(); 

        return view('kriterias.index', compact('kriteriapenilaian', 'kriterias'));
    }

    public function update(KriteriaPenilaianUpdateRequest $request, KriteriaPenilaian $kriteriapenilaian)
    {
        $kriteriapenilaian->update($request->validated());

        return redirect()->back()->with('success', 'Data kriteria berhasil diubah!');
    }

    public function destroy(KriteriaPenilaian $kriteriapenilaian)
    {
        $kriteriapenilaian->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}
