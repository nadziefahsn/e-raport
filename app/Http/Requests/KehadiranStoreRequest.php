<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KehadiranStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

 @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     
    public function rules(): array
    {
        return [
            'anggota_kelas-id' => 'required|exists:anggota_kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'sakit' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'tanpa_keterangan' => 'required|integer|min:0',
        ];
    }
}
