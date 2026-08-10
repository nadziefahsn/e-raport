<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Http\Requests\SekolahUpdateRequest;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sekolah = Sekolah::first();
        return view('sekolahs.index', compact('sekolah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SekolahUpdateRequest $request, Sekolah $sekolah)
    {
    $data = $request->validated();

    $sekolah->update($data);

    return redirect()
        ->route('sekolah.index')
        ->with('success', 'Profil sekolah berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        //
    }
}
