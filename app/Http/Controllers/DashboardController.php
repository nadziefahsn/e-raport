<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;

class DashboardController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::first();

        return view('dashboard.index', compact('sekolah'));
    }
}
