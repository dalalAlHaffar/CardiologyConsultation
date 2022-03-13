<?php

namespace App\Http\Requests\Consulate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'image'      => 'nullable|mimes:jpg,png,jpeg',
            'brief_description' => 'nullable|string',
            'category_id'      => 'required|exists:categories,id',
            'tags'            =>'required|array',
            'tags.*'           =>'required|string',
        ];
    }
}
