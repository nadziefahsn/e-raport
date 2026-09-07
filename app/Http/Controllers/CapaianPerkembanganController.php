<?php

namespace App\Http\Controllers;

use App\Models\CapaianPerkembangan;
use Illuminate\Http\Request;
use App\Http\Requests\CapaianPerkembanganUpdateRequest;

class CapaianPerkembanganController extends Controller
{
    
    public function index()
    {
        $capaianPerkembangan = CapaianPerkembangan::latest()->get();

        return view('capaians.index', compact('capaianPerkembangan'));
    }

    
    public function create()
    {
        return view('capaians.index');
    }

    
    public function store(CapaianPerkembanganUpdateRequest $request)
    {
        CapaianPerkembangan::create($request->validated());

        return redirect()->back()->with('success', 'Data capaian perkembangan berhasil ditambahkan!');
    }

    
    public function show(string $id)
    {
        return view('capaians.index');
    }

   
    public function edit(string $id)
    {
        return view('capaians.index', compact('capaianPerkembangan'));
    }

    
    public function update(CapaianPerkembanganUpdateRequest $request, string $id)
    {
        $capaian = CapaianPerkembangan::findOrFail($id);
        $capaian->update($request->validated());

        return redirect()->back()->with('success', 'Data capaian perkembangan berhasil diperbarui!');
    }

    
    public function destroy(string $id)
    {
        $capaian = CapaianPerkembangan::findOrFail($id);
        $capaian->delete();

        return redirect()->back()->with('success', 'Data capaian perkembangan berhasil dihapus!');
    }
}
