<?php

namespace App\Validation;

class LoginRules
{
    public static function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ];
    }

    public static function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'password.required' => 'パスワードを入力してください',
        ];
    }
}
