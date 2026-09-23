<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\CapaianPerkembangan;
use App\Models\TahunAjaran;
use App\Http\Requests\IndikatorUpdateRequest;

class IndikatorController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $capaians = CapaianPerkembangan::all();
        $indikators = Indikator::with(['capaianPerkembangan', 'tahunAjaran'])->whereTahunAjaranId($tahunAjaranAktif->id)->get();

        return view('indikators.index', compact('capaians', 'indikators', 'tahunAjaranAktif'));
    }

    public function create()
    {
        return view('indikators.index');
    }

    public function store(IndikatorUpdateRequest $request)
    {
        Indikator::create($request->validated());

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view('indikators.index');
    }

    public function edit(string $id)
    {
        $indikator = Indikator::findOrFail($id);
        return view('indikators.index', compact('indikator'));
    }

    public function update(IndikatorUpdateRequest $request, Indikator $indikator)
    {
        $indikator->update($request->validated());

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(Indikator $indikator)
    {
        $indikator->delete();

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator Berhasil Dihapus!');
    }
}