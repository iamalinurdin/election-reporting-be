<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DaftarPemilihRequest extends FormRequest
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
          'id_relawan'   => 'numeric',
          'nama_pemilih' => 'required|string',
          'nik'          => 'required|string',
          'alamat'       => 'required|string',
          'kordinat'     => 'required|string',
          'photo'        => 'mimes:jpeg,png,jpg,webp',
        ];
    }
}
