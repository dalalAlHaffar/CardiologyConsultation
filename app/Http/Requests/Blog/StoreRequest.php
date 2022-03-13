<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
            'image'      => 'required|mimes:jpg,png,jpeg',
            'brief_description' => 'nullable|string',
            'category_id'      => 'required|exists:categories,id',
            'tags'            =>'required|array',
            'tags.*'           =>'required|string',
        ];
    }
}
