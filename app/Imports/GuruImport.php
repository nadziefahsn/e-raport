<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama_guru'])) {
            return null;
        }

        if (!empty($row['nip'])) {
            $guruAda = Guru::where('nip', $row['nip'])->first();
            if ($guruAda) {
                $guruAda->update([
                    'nama_guru' => $row['nama_guru'],
                    'jabatan'   => $row['jabatan'] ?? $guruAda->jabatan,
                ]);
                return null;
            }
        }

        return DB::transaction(function () use ($row) {
            $email = !empty($row['email']) 
                ? $row['email'] 
                : strtolower(Str::slug($row['nama_guru'], '')) . '_' . Str::random(5) . '@mail.com';

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $row['nama_guru'],
                    'email'    => $email,
                    'password' => Hash::make('password123'),
                ]);

                if (method_exists($user, 'assignRole')) {
                    $user->assignRole('guru');
                }
            }

            return new Guru([
                'user_id'   => $user->id,
                'nama_guru' => $row['nama_guru'],
                'jabatan'   => $row['jabatan'] ?? '-',
                'nip'       => $row['nip'] ?? null,
            ]);
        });
    }

    public function headingRow(): int
    {
        return 1;
    }
}