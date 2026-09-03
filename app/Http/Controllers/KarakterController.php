<?php

namespace App\Http\Controllers;

use App\Http\Requests\KarakterStoreRequest;
use App\Http\Requests\KarakterUpdateRequest;
use App\Models\Karakter;
use Illuminate\Http\Request;

class KarakterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karakters = Karakter::all();
        return view('karakters.index', compact('karakters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('karakter.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KarakterStoreRequest $request)
    {
        $data = $request->validated();

        if (Karakter::where('id', $data['id'])->exists()) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Kode karakter "' . $data['id'] . '" sudah tersedia.');
        }

        Karakter::create($data);

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Data karakter berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karakter $karakter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karakter $karakter)
    {
        return redirect()->route('karakter.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KarakterUpdateRequest $request, Karakter $karakter)
    {
        $data = $request->validated();

        if ($data['id'] !== $karakter->id && Karakter::where('id', $data['id'])->exists()) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Kode karakter "' . $data['id'] . '" sudah tersedia.');
        }

        $karakter->update($data);

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Data karakter berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karakter $karakter)
    {
        $karakter->delete();

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Data karakter berhasil dihapus.');
    }
}