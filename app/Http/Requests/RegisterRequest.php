<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "email" => "required|string|email|unique:users",
            "password" => 'required|same:confirmed_password|regex:"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"',
        ];
    }
}
