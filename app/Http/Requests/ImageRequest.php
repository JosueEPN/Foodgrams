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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => 'required|mimes:jpg,png,jpeg|max:3000',
            'text' => 'required|string',
            'text2' => 'required|string',
            'text3' => 'required|string',
            'number' => 'numeric|min:0|not_in:0'
        ];
    }
    public function messages(){
        return [
            'image.required' => 'Tiene que seleccionar una imagen',
            'title.required' => 'Tienes que colocar un titulo a la receta',
        ];
    }
}
