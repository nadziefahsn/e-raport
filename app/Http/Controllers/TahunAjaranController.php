<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Http\Requests\TahunAjaranStoreRequest;
use App\Http\Requests\TahunAjaranUpdateRequest;

class TahunAjaranController extends Controller
{

    public function index()
    {
        $tahun_ajarans = TahunAjaran::all();

        return view('tahun.index', compact('tahun_ajarans'));
    }


    public function create()
    {
        return redirect()->route('tahun_ajaran.index');
    }


    public function store(TahunAjaranStoreRequest $request)
    {
        TahunAjaran::create($request->validated());

        return redirect()
            ->route('tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }


    public function show(TahunAjaran $tahunAjaran)
    {
        return redirect()->route('tahun_ajaran.index');
    }


    public function edit(TahunAjaran $tahunAjaran)
    {
        return redirect()->route('tahun_ajaran.index');
    }

    public function update(TahunAjaranUpdateRequest $request, TahunAjaran $tahunAjaran) 
    {
        $tahunAjaran->update($request->validated());

        return redirect()
            ->route('tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }


    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();

        return redirect()
            ->route('tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}