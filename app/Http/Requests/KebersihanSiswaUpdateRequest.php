<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KebersihanSiswaUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
     
    public function rules(): array
    {
        return [
            'anggota_kelas_id'   => 'required|array',
            'anggota_kelas_id.*' => 'required',
            'hasil_pakaian'      => 'nullable|array',
            'hasil_pakaian.*'    => 'nullable|string',
            'hasil_kuku'         => 'nullable|array',
            'hasil_kuku.*'       => 'nullable|string',
            'hasil_rambut'       => 'nullable|array',
            'hasil_rambut.*'     => 'nullable|string',
            'hasil_kulit'        => 'nullable|array',
            'hasil_kulit.*'      => 'nullable|string',
            'keterangan'         => 'nullable|array',
            'keterangan.*'       => 'nullable|string',
        ];
    }
}
