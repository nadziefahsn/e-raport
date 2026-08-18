<?php

namespace App\Http\Controllers;

use App\Models\CapaianPerkembangan;
use Illuminate\Http\Request;
use App\Http\Requests\CapaianPerkembanganStoreRequest;
use App\Http\Requests\CapaianPerkembanganUpdateRequest;

class CapaianPerkembanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capaianPerkembangan = CapaianPerkembangan::latest()->get();

        return view('capaians.index', compact('capaianPerkembangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('capaians.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CapaianPerkembanganStoreRequest $request)
    {
        CapaianPerkembangan::create($request->validated());

        return redirect()->back()->with('success', 'Data capaian perkembangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('capaians.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('capaians.index', compact('capaianPerkembangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CapaianPerkembanganUpdateRequest $request, string $id)
    {
        $capaian = CapaianPerkembangan::findOrFail($id);
        $capaian->update($request->validated());

        return redirect()->back()->with('success', 'Data capaian perkembangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $capaian = CapaianPerkembangan::findOrFail($id);
        $capaian->delete();

        return redirect()->back()->with('success', 'Data capaian perkembangan berhasil dihapus!');
    }
}
