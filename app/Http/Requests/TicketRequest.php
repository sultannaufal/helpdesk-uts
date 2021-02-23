<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'theme' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'location_id' => 'required|integer|max:255',
            'attachment' => 'required|image|max:2000',
        ];
    }

    public function messages()
    {
        return[
            'theme.required' => 'Judul tidak boleh kosong',
            'theme.string' => 'Tolong Masukkan Keluhan Anda',
            'theme.max' => 'Terlalu Banyak Karakter',
            'content.required' => 'Detail tidak boleh kosong',
            'content.string' => 'Tolong Deskripsikan Keluhan Anda',
            'content.max' => 'Terlalu Banyak Karakter',
            'location_id.required' => 'Silahkan Pilih lokasi',
            'location_id.integer' => 'Silahkan Pilih lokasi',
            'location_id.max' => 'Silahkan Pilih Lokasi',
            'attachment.required' => 'Mohon sertakan gambar',
            'attachment.file' => 'Mohon sertakan gambar',
            'attachment.max' => 'Nama File Terlalu Panjang',
        ];
    }
}
