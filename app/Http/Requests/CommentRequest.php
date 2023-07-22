<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CommentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required'
        ];
    }

    /**
     * Trow Error Validation
     *
     * @param Validator $validator
     * @return json
     */
    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([

            'success' => false,

            'message' => 'Kesalahan validasi',

            'data' => $validator->errors()

        ], 422));
    }

    /**
     * Error Message
     *
     * @return void
     */
    public function messages()
    {

        return [

            'comment.required' => 'Comment Wajib Di isi'

        ];
    }
}
