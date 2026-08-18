<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\CapaianPerkembangan;
use Illuminate\Http\Request;
use App\Http\Requests\IndikatorStoreRequest;
use App\Http\Requests\IndikatorUpdateRequest;

class IndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capaians = CapaianPerkembangan::all();
        $indikators = Indikator::all();

        return view('indikators.index', compact('capaians','indikators',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('indikators.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IndikatorStoreRequest $request)
    {
        Indikator::create($request->validated());

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('indikators.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('indikators.index', compact('Indikator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndikatorUpdateRequest $request, Indikator $indikator)
    {
        $indikator->update($request->validated());

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Indikator $indikator)
    {
        $indikator->delete();
        return redirect()->route('indikator.index')
        ->with('success', 'Indikator Berhasil Dihapus!');
    }
}
