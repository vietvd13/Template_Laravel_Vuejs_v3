<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "user_name" => ["required", "regex:/(\w{2,}@\w{2,}\.\w{2,8})|(^(0)[0-9]{9,12}$)/"],
            "password" => "required",
        ];
    }
}
