<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaStoreRequest extends FormRequest
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
     * @return array<string=> 'required', \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nis'=> 'required|string|unique:siswas,nis',
            'nama_siswa'=> 'required|string',
            'nisn'=> 'nullable|string',
            'jenis_kelamin'=> 'required',
            'tempat_lahir'=> 'required|string',
            'tanggal_lahir'=> 'required|date',
            'agama'=> 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Khonghucu',
            'nama_ayah'=> 'required',
            'nama_ibu'=> 'required',
            'pekerjaan_ayah'=> 'required',
            'pekerjaan_ibu'=> 'required',
            'alamat'=> 'required',
            'telepon'=> 'required|string',
            'kelas_id'=> 'required|exists:kelas,id',
            'semester'=> 'required|exists:tahun_ajarans,id',
        ];
    }
}
