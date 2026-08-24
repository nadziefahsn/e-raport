<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KesehatanMataUpdateRequest extends FormRequest
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
            'anggota_kelas_id'   => 'required|array',
            'anggota_kelas_id.*' => 'required|exists:anggota_kelas,id',
            'ketajaman_kanan'    => 'nullable|array',
            'ketajaman_kanan.*'  => 'nullable|in:Baik,Kurang baik',
            'ketajaman_kiri'     => 'nullable|array',
            'ketajaman_kiri.*'   => 'nullable|in:Baik,Kurang baik',
            'buta_warna'         => 'nullable|array',
            'buta_warna.*'       => 'nullable|in:Baik,Kurang baik',
            'radang_kanan'       => 'nullable|array',
            'radang_kanan.*'     => 'nullable|in:Baik,Kurang baik',
            'radang_kiri'        => 'nullable|array', 
            'radang_kiri.*'      => 'nullable|in:Baik,Kurang baik', 
            'juling_kanan'       => 'nullable|array',
            'juling_kanan.*'     => 'nullable|in:Baik,Kurang baik',
            'juling_kiri'        => 'nullable|array',
            'juling_kiri.*'      => 'nullable|in:Baik,Kurang baik',
        ];
    }
}
