<?php

namespace App\Http\Controllers;

use App\Models\Hafalan;
use Illuminate\Http\Request;
<<<<<<< HEAD

class HafalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Hafalan $hafalan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hafalan $hafalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hafalan $hafalan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hafalan $hafalan)
    {
        //
=======
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
>>>>>>> 0e508e9d92c8a29950cbf2643a6f271e7cefeb76
    }
}
