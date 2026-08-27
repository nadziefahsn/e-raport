<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\NilaiKarakter;
use App\Models\Karakter;
use Illuminate\Support\Facades\Auth;

class KarakterController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $karakters = Karakter::all();
        // Memanggil data tanpa relasi 'with' agar tidak bentrok dengan database
        $anggotaKelas = AnggotaKelas::all();

      return view('karakters.index', compact('karakters', 'anggotaKelas'));
    }

    public function store(Request $request)
    {
        if ($request->has('nilai')) {
            foreach ($request->nilai as $item) {
                NilaiKarakter::updateOrCreate(
                    ['anggota_kelas_id' => $item['anggota_kelas_id']],
                    ['skor' => $item['skor']]
                );
            }
            return redirect()->back()->with('success', 'Nilai karakter berhasil disimpan!');
        }

        return redirect()->back()->with('error', 'Tidak ada data nilai yang dikirim.');
    }
}