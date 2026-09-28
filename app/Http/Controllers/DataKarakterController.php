<?php

namespace App\Http\Controllers;

use App\Models\DataKarakter;
use App\Models\Karakter;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class DataKarakterController extends Controller
{
   
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::latest()->first();

        $karakters = $tahunAjaranAktif 
            ? Karakter::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get() 
            : collect();

        return view('data_karakters.index', compact('karakters', 'tahunAjaranAktif'));
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
    
    }

    
    public function show(DataKarakter $dataKarakter)
    {
        
    }

    
    public function edit(DataKarakter $dataKarakter)
    {
        
    }

    
    public function update(Request $request, DataKarakter $dataKarakter)
    {
        
    }

   
    public function destroy(DataKarakter $dataKarakter)
    {
        
    }
}
