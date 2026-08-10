<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;

class DashboardController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::first();
        if (!$sekolah) {
            return redirect()->route('sekolah.index');
        }else{
        return view('dashboard.index', compact('sekolah'));
    }
    }
}
