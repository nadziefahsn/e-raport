<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Pengumuman;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sekolah = Sekolah::first();
        $pengumumans = Pengumuman::latest()->get();

        $jumlahSiswa = Siswa::count();
        $jumlahGuru = Guru::count();
        $jumlahKelas = Kelas::count();

        if (!$sekolah) {
            return redirect()->route('sekolah.index');
        }else{
        return view('dashboard.index', compact('sekolah', 'pengumumans', 'jumlahSiswa', 'jumlahGuru', 'jumlahKelas'));
    }
    }
}
