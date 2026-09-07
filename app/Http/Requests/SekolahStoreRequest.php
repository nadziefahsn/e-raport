<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SekolahStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

@return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    
    public function rules(): array
    {
        return [
        'nama_sekolah' => 'required',
        'npsn' => 'required',
        'alamat' => 'required',
        'kode' => 'required',
        'telepon' => 'required',
        'desa' => 'required',
        'kecamatan' => 'required',
        'kabupaten' => 'required',
        'provinsi' => 'required',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
