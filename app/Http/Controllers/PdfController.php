<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\KriteriaPenilaian;
use App\Models\KebersihanSiswa;
use App\Models\Sekolah;

class PdfController extends Controller
{
    public function index()
    {
        $kriterias = KriteriaPenilaian::all();
        $kebersihanSiswa = KebersihanSiswa::all();
        $sekolah = KebersihanSiswa::all();


        $pdf = Pdf::loadView('pdf.rapot', compact('kriterias', 'kebersihanSiswa', 'sekolah'));
        return $pdf->stream('invoice.pdf');
    
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
