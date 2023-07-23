<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\Base64Image;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'image' => ['required', new Base64Image],
            'content' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Kesalahan validasi',
            'data' => $validator->errors()
        ], 422));
    }



    public function messages()
    {
        return [
            'title.required' => 'Judul Wajib Di isi',
            'image.required' => 'Image Wajib Di isi',
            'content.required' => 'Content Wajib Di isi',
        ];
    }
}
