<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
=======
use App\Models\Guru; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('gurus.index', compact('gurus'));
=======
        $gurus = Guru::with('user')->get();
        $users = User::all();

        return view('gurus.index', compact('gurus', 'users'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->user_id = $request->user_id;
        $guru->save();

        return redirect()->back()->with('success', 'User ID berhasil diperbarui.');
>>>>>>> fitur-user
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
=======
        // 1. Validasi input dari form
        $request->validate([
            'email'     => 'required|email|unique:users,email',
            'nama_guru' => 'required',
            'jabatan'   => 'required',
            'nip'       => 'nullable|unique:gurus,nip',
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email'    => 'Format email tidak valid!',
            'email.unique'   => 'Email tersebut sudah digunakan!',
            'nip.unique'     => 'NIP tersebut sudah digunakan oleh guru lain!',
        ]);

        // 2. Simpan ke tabel User
        $user = User::create([
            'name'     => $request->nama_guru,
            'email'    => $request->email,
            'password' => Hash::make('password123'),
            'role'     => 'guru',
        ]);

        // 3. Simpan ke tabel Guru (Diisi default dummy agar MySQL tidak menolak karena NOT NULL)
        Guru::create([
            'user_id'       => $user->id,
            'nama_guru'     => $request->nama_guru,
            'jabatan'       => $request->jabatan,
            'nip'           => $request->nip,
            'tempat_lahir'  => '-',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'Laki-Laki',
        ]);

        return redirect()->back()->with('success', 'Data Guru berhasil disimpan!');
>>>>>>> fitur-user
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
=======
        return view('gurus.index', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        // 1. Validasi input
        $request->validate([
            'email'     => 'required|email|unique:users,email,' . ($guru->user_id ?? 0),
            'nama_guru' => 'required',
            'jabatan'   => 'required',
            'nip'       => 'nullable|unique:gurus,nip,' . $guru->id,
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email'    => 'Format email tidak valid!',
            'email.unique'   => 'Email tersebut sudah digunakan!',
            'nip.unique'     => 'NIP tersebut sudah digunakan oleh guru lain!',
        ]);

        // 2. Update Email dan Nama di tabel Users
        if ($guru->user) {
            $guru->user->update([
                'email' => $request->email,
                'name'  => $request->nama_guru,
            ]);
        }

        // 3. Update Data di tabel Guru
        $guru->update([
            'nama_guru' => $request->nama_guru,
            'jabatan'   => $request->jabatan,
            'nip'       => $request->nip,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        // Opsional: Hapus user terkait jika ada
        if ($guru->user) {
            $guru->user->delete();
        }

        $guru->delete();
        return redirect()->back()->with('success', 'Data guru berhasil dihapus!');
    }

    /**
     * Menampilkan form reset password guru
     */
    public function editPassword($id)
    {
        $guru = Guru::findOrFail($id);
        return view('gurus.reset-password', compact('guru'));
    }

    /**
     * Memproses perbaruan password akun user milik guru
     */
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|max:8|confirmed',
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.max'       => 'Password maksimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $guru = Guru::findOrFail($id);

        if (!$guru->user_id) {
            return redirect()->back()->with('error', 'Guru ini belum terhubung ke akun User!');
        }

        $user = User::findOrFail($guru->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('guru.index')->with('success', 'Password berhasil diperbarui!');
    }
>>>>>>> fitur-user
}