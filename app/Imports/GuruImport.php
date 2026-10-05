<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama'])) {
            return null;
        }

        $nipy = !empty($row['nipy']) ? $row['nipy'] : (!empty($row['nuptk']) ? $row['nuptk'] : '-');

        if ($nipy !== '-') {
            $guruAda = Guru::where('nip', $nipy)->first();
            if ($guruAda) {
                $guruAda->update([
                    'nama_guru' => $row['nama'],
                    'jabatan'   => $row['jabatan'] ?? $guruAda->jabatan,
                ]);
                return null;
            }
        }

        return DB::transaction(function () use ($row, $nipy) {
            $username = $nipy;

            $user = User::where('email', $username)->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $row['nama'],
                    'email'    => $username,
                    'password' => Hash::make('password123'),
                ]);

                if (method_exists($user, 'assignRole')) {
                    $user->assignRole('guru');
                }
            }

            return new Guru([
                'user_id'   => $user->id,
                'nama_guru' => $row['nama'],
                'jabatan'   => $row['jabatan'] ?? '-',
                'nip'       => $nipy,
            ]);
        });
    }

    public function headingRow(): int
    {
        return 1;
    }
}