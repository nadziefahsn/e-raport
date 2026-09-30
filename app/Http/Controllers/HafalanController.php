<?php

namespace App\Http\Controllers;

use App\Models\Hafalan;
use Illuminate\Http\Request;
use App\Http\Requests\HafalanRequest;

class HafalanController extends Controller
{

    public function index()
    {
        $hafalans = Hafalan::latest()->get();

        return view('hafalans.index', compact('hafalans'));
    }

    public function create()
    {
        return view('hafalans.index');
    }

    public function store(HafalanRequest $request)
    {
        Hafalan::create($request->validated());

        return redirect()->back()->with('success', 'Data hafalan berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return view('hafalans.index');
    }

    public function edit(string $id)
    {
        return view('hafalans.index', compact('hafalans'));
    }

    public function update(HafalanRequest $request, string $id)
    {
        $hafalan = Hafalan::findOrFail($id);
        $hafalan->update($request->validated());

        return redirect()->back()->with('success', 'Data hafalan berhasil diperbarui!');    
    }

    public function destroy(string $id)
    {
        $hafalan = Hafalan::findOrFail($id);
        $hafalan->delete();

        return redirect()->back()->with('success', 'Data hafalan berhasil dihapus!');    
    }
}
