<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnggotaKelasUpdateRequest extends FormRequest
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
        $anggotaKelasId = $this->route('anggotaKelas') 
            ? ($this->route('anggotaKelas')->id ?? $this->route('anggotaKelas')) 
            : $this->id;

        return [
            'nis_id' => [
                'required',
                'exists:siswas,nis',
                Rule::unique('anggota_kelas', 'nis_id')->ignore($anggotaKelasId),
            ],
            'kelas_id' => [
                'required',
                'exists:kelas,id',
            ],
        ];
    }
}
