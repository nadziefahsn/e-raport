<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AnggotaKelasStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
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
