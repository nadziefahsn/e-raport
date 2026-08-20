<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KehadiranUpdateRequest extends FormRequest
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
            'sakit'              => 'nullable|array',
            'sakit.*'            => 'nullable|integer|min:0',
            'izin'               => 'nullable|array',
            'izin.*'             => 'nullable|integer|min:0',
            'tanpa_keterangan'   => 'nullable|array',
            'tanpa_keterangan.*' => 'nullable|integer|min:0',
        ];
    }
}
