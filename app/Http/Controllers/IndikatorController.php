<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\CapaianPerkembangan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\IndikatorUpdateRequest;

class IndikatorController extends Controller
{
   
    public function index()
    {
        $capaians = CapaianPerkembangan::all();
        $indikators = Indikator::all();
        $tahunAjarans = TahunAjaran::all();

        return view('indikators.index', compact('capaians','indikators','tahunAjarans'));
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
            ->with('success', 'Indikator berhasil ditambahkan.');
    }

    
    public function show(string $id)
    {
        return view('indikators.index');
    }

   
    public function edit(string $id)
    {
        return view('indikators.index', compact('Indikator'));
    }

    
    public function update(IndikatorUpdateRequest $request, Indikator $indikator)
    {
        $indikator->update($request->validated());

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil diupdate.');
    }

   
    public function destroy(Indikator $indikator)
    {
        $indikator->delete();
        return redirect()->route('indikator.index')
        ->with('success', 'Indikator Berhasil Dihapus!');
    }
}
