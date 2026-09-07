<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Http\Requests\SekolahUpdateRequest;

class SekolahController extends Controller
{

    public function index()
    {
        $sekolah = Sekolah::first();

        return view('sekolahs.index', compact('sekolah'));
    
    
    }

    public function create()
    {
        
    }


    public function store(SekolahUpdateRequest $request)
    {
        $data = $request-> validated();

        Sekolah::create($data);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profil sekolah berhasil disimpan');

    }


    public function show(Sekolah $sekolah)
    {
        
    }


    public function edit(Sekolah $sekolah)
    {
       
    }

    public function update (SekolahUpdateRequest $request, Sekolah $sekolah) 
    {
        $data = $request->validated();

        $sekolah->update($data);

        return redirect()
            ->route('sekolah.index')
            ->with('success', 'Profil sekolah berhasil diperbarui');
}


    public function destroy(Sekolah $sekolah)
    {
      
    }
}
