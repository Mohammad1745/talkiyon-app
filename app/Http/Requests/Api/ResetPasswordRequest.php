<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ():array
    {
        return [
            'phone' => 'required|regex: /^(01){1}[1-9]{1}[0-9]{8}$/',
            'code' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ];
    }
}
