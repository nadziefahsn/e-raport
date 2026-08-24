<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KesehatanTelingaUpdateRequest extends FormRequest
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
            'anggota_kelas_id'       => 'required|array',
            'anggota_kelas_id.*'     => 'required|exists:anggota_kelas,id',
            'pendengaran_kanan'   => 'nullable|array',
            'pendengaran_kanan.*' => 'nullable|string',
            'pendengaran_kiri'    => 'nullable|array',
            'pendengaran_kiri.*'  => 'nullable|string',
            'radang_kanan'        => 'nullable|array',
            'radang_kanan.*'      => 'nullable|string',
            'radang_kiri'         => 'nullable|array',
            'radang_kiri.*'       => 'nullable|string',
        ];
    }
}
