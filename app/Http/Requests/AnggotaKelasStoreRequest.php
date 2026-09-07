<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AnggotaKelasStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nis_id' => [
                'required',
                'exists:siswas,nis',
                'unique:anggota_kelas,nis_id', 
            ],
            'kelas_id' => [
                'required',
                'exists:kelas,id',
            ],
        ];
    }
}
