<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'attachment' => 'nullable|file|max:2000',
        ];
    }

    public function messages()
    {
        return[
            'theme.required' => 'Judul tidak boleh kosong',
            'content.required' => 'Detail tidak boleh kosong',
        ];
    }
}
