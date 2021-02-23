<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'before' => 'required|image|max:2000',
            'after' => 'required|image|max:2000',
        ];
    }

    public function messages()
    {
        return[
            'before.required' => 'Mohon sertakan gambar',
            'before.image' => 'Mohon sertakan gambar',
            'before.size' => 'Size tidak boleh lebih dari 2mb',
            'after.required' => 'Form tidak boleh kosong',
            'after.image' => 'Mohon sertakan gambar',
            'after.size' => 'Size tidak boleh lebih dari 2mb',
        ];
    }
}
