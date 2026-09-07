<?php

namespace App\Http\Controllers;

use App\Models\DataKarakter;
use App\Models\Karakter;
use Illuminate\Http\Request;

class DataKarakterController extends Controller
{
   
    public function index()
    {
        $karakters = Karakter::all();

        return view('data_karakters.index', compact('karakters'));
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
