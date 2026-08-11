<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Requests\GuruStoreRequest;
use App\Http\Requests\GuruUpdateRequest;
use App\Models\User;                    
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::all();

        return view('gurus.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gurus.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $autoEmail = 'guru.' . Str::slug($request->nip) . '@sekolah.id';

        $user = User::create([
        'name'     => $request->nama_guru,
        'email'    => $autoEmail,
        'password' => Hash::make('password123'),
        'role'     => 'guru',
    ]);

        Guru::create([
        'user_id'       => $user->id,
        'nama_guru'     => $request->nama_guru,
        'jabatan'       => $request->jabatan,
        'nip'           => $request->nip,
        'tempat_lahir'  => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
    ]);

    return redirect()->back()->with('success', 'Data Guru berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        return view('gurus.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('gurus.index', compact('Guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $guru->update([
        'nama_guru'     => $request->nama_guru,
        'jabatan'       => $request->jabatan,
        'nip'           => $request->nip,
        'tempat_lahir'  => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
    ]);

    return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')
        ->with('success', 'Peminjam deleted successfully');
    }
}
