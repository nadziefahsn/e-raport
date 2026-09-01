<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HasilCapaianUpdateRequest extends FormRequest
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
            'anggota_kelas_id.*' => 'required|exists:anggota_kelas,id',
            'indikator_id.*'     => 'required|exists:indikators,id',
            'nilai'              => 'nullable|array',
            'nilai.*.*'          => 'nullable|in:BB, MB, BSH, BSB',
        ];
    }
}
