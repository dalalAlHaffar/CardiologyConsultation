<?php

namespace App\Http\Requests\Consulate;

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
            'medical_history'      =>  'required|string',
            'name' => 'required|string',
            'phone' => 'required',
            'age' => 'nullable|numeric',
            'gender' => 'required|in:male,female',
            'captcha' => 'required|captcha'
        ];
    }
}
