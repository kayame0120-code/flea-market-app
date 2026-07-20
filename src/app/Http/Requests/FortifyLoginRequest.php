<?php

namespace App\Http\Requests;

use App\Validation\LoginRules;
use Laravel\Fortify\Http\Requests\LoginRequest;

class FortifyLoginRequest extends LoginRequest
{
    public function rules()
    {
        return LoginRules::rules();
    }

    public function messages()
    {
        return LoginRules::messages();
    }
}
