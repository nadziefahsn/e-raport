<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GuruStoreRequest extends FormRequest
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
            'nama_guru' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'required|numeric|unique:gurus,nip',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ];
    }

    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $nip = $this->input('nip');
        if ($nip) {
            $autoEmail = 'guru.' . \Illuminate\Support\Str::slug($nip) . '@sekolah.id';

            if (\App\Models\User::where('email', $autoEmail)->exists()) {
                $validator->errors()->add('nip', 'NIP ini menghasilkan email akun yang sudah terdaftar!');
            }
        }
    });
}

public function messages(): array
{
    return [
        'nip.unique'   => 'NIP ini sudah digunakan oleh guru lain!',
        'nip.required' => 'NIP wajib diisi.',
    ];
}
}