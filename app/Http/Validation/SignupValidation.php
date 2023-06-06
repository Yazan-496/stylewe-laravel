<?php

namespace App\Http\Validation;

use Illuminate\Support\Facades\Validator;

class SignupValidation
{
    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'photo' => 'string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    }
    public static function messages()
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already taken.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least 6 characters.',
        ];
    }
    public static function validate(array $data)
    {
        return Validator::make($data, self::rules(), self::messages());
    }
}
