<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SekolahUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    
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
