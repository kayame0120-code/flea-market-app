<?php

namespace App\Validation;

class RegisterRules
{
    public static function rules()
    {
        return [
            'name' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public static function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.string' => 'お名前は文字列でなければなりません',
            'name.max' => 'お名前は20文字以内で入力してください。',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください', 'password.confirmed' => 'パスワードと一致しません',
        ];
    }
}
