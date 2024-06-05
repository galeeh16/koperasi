<?php

namespace App\Http\Requests\Anggota;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnggotaRequest extends FormRequest
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
            'username' => ['required', 'string', 'min:3', 'max:30', 'unique:anggota,username'],
            'nama_lengkap' => ['required', 'string', 'min:3', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'in:l,p'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'string', 'date_format:d-m-Y'],
            'status_menikah' => ['required', 'string'],
            'departemen' => ['required', 'string'],
            'pekerjaan' => ['required', 'string'],
            'agama' => ['required', 'string'],
            'alamat' => ['nullable', 'string'],
            'kota' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string'],
            'photo' => ['nullable']
        ];
    }
}
