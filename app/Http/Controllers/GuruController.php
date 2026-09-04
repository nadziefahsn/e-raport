<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('gurus.index', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'nama_guru' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Akun User Baru (Default Password: password123)
            $user = User::create([
                'name' => $request->nama_guru,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => 'guru',
            ]);

            // 2. Buat Data Guru
            Guru::create([
                'user_id' => $user->id,
                'email' => $request->email,
                'nama_guru' => $request->nama_guru,
                'jabatan' => $request->jabatan,
                'nip' => $request->nip,
            ]);
        });

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil ditambahkan! Password default: password123');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'nama_guru' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request, $guru) {
            // Update Data Guru
            $guru->update([
                'email' => $request->email,
                'nama_guru' => $request->nama_guru,
                'jabatan' => $request->jabatan,
                'nip' => $request->nip,
            ]);

            // Update Data User Terkait
            if ($guru->user) {
                $guru->user->update([
                    'name' => $request->nama_guru,
                    'email' => $request->email,
                ]);
            }
        });

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        DB::transaction(function () use ($guru) {
            if ($guru->user) {
                $guru->user->delete();
            }
            $guru->delete();
        });

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil dihapus!');
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|max:8|confirmed',
        ]);

        $guru = Guru::findOrFail($id);

        if ($guru->user) {
            $guru->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('guru.index')->with('success', 'Password Guru berhasil diubah!');
    }
}