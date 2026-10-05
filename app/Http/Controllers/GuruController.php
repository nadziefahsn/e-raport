<?php

namespace App\Http\Controllers;

use App\Models\Guru; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuruImport;

class GuruController extends Controller
{
    public function importForm()
    {
        return view('gurus.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'File Excel wajib diunggah!',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv!',
            'file.max'      => 'Ukuran file maksimal 2MB!',
        ]);

        Excel::import(new GuruImport, $request->file('file'));

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil di-import!');
    }

    public function index()
    {
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
    }

    public function create()
    {
        return view('gurus.create');
    }

   
    public function store(Request $request)
    {
        
        $request->validate([
            'email'     => 'required|string|unique:users,email',
            'nama_guru' => 'required',
            'jabatan'   => 'required',
            'nip'       => 'nullable|unique:gurus,nip',
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email'    => 'Format email tidak valid!',
            'email.unique'   => 'Email tersebut sudah digunakan!',
            'nip.unique'     => 'NIP tersebut sudah digunakan oleh guru lain!',
        ]);

        
        DB::transaction(function () use ($request) {
        $user = User::create([
            'name'     => $request->nama_guru,
            'email'    => $request->email,
            'password' => Hash::make('password123'),
            'role'     => 'guru',
        ]);

        Guru::create([
            'user_id'   => $user->id,
            'nama_guru' => $request->nama_guru,
            'jabatan'   => $request->jabatan,
            'nip'       => $request->nip,
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('guru');
        }
    });

        return redirect()->back()->with('success', 'Data Guru berhasil disimpan!');
    }

   
    public function show(Guru $guru)
    {
        return view('gurus.index');
    }

   
    public function edit(Guru $guru)
    {
        return view('gurus.edit', compact('guru'));
    }

    
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

      
        $request->validate([
            'email'     => 'required|string|unique:users,email,' . ($guru->user_id ?? 0),
            'nama_guru' => 'required',
            'jabatan'   => 'required',
            'nip'       => 'nullable|unique:gurus,nip,' . $guru->id,
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email'    => 'Format email tidak valid!',
            'email.unique'   => 'Email tersebut sudah digunakan!',
            'nip.unique'     => 'NIP tersebut sudah digunakan oleh guru lain!',
        ]);

        
        if ($guru->user) {
            $guru->user->update([
                'email' => $request->email,
                'name'  => $request->nama_guru,
            ]);
        }

        $guru->update([
            'nama_guru' => $request->nama_guru,
            'jabatan'   => $request->jabatan,
            'nip'       => $request->nip,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }


    public function destroy(Guru $guru)
    {

        if ($guru->user) {
            $guru->user->delete();
        }

        $guru->delete();
        return redirect()->back()->with('success', 'Data guru berhasil dihapus!');
    }

    public function editPassword($id)
    {
        $guru = Guru::findOrFail($id);
        return view('gurus.reset-password', compact('guru'));
    }


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
}