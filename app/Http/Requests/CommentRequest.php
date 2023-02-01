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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'comment' => 'required|max:255'
        ];
    }

    public function messages()
    {
       return[
        'comment.required' => 'No puedes comentar texto vacio',
        'comment.max' => 'No puedes comentar mas de 255 caracteres'
       ];
    }
}
