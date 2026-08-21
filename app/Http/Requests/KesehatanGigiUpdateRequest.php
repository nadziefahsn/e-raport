<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KesehatanGigiUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'guru_id' => 'nullable',
            'anggota_kelas_id' => 'required|array',
            'anggota_kelas_id.*' => 'required|exists:anggota_kelas,id',
            'kesehatan_gigi' => 'required|array',
            'kesehatan_gigi.*' => 'required|in:Baik,Kurang baik',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string',
        ];
    }
}
