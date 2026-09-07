<?php

namespace App\Http\Controllers;

use App\Http\Requests\KarakterStoreRequest;
use App\Http\Requests\KarakterUpdateRequest;
use App\Models\Karakter;
use Illuminate\Http\Request;

class KarakterController extends Controller
{
   
    public function index()
    {
        $karakters = Karakter::all();
        return view('karakters.index', compact('karakters'));
    }

   
    public function create()
    {
        return redirect()->route('karakter.index');
    }

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

    
    public function show(Karakter $karakter)
    {
        
    }

    public function edit(Karakter $karakter)
    {
        return redirect()->route('karakter.index');
    }

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

    public function destroy(Karakter $karakter)
    {
        $karakter->delete();

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Data karakter berhasil dihapus.');
    }
}