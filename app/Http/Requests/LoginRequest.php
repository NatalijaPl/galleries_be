<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "email" => "required|string|email",
            'password' => 'required|regex:"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"'
        ];
    }
}
